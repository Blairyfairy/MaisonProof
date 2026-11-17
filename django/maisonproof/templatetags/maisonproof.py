import json
import re
from urllib.parse import quote
from urllib.request import Request, urlopen
from django import template
from django.conf import settings
from django.utils.html import format_html

register = template.Library()

@register.simple_tag
def maisonproof_badge(sku):
    """Fail closed: show a badge only when the service confirms authentication."""
    base = getattr(settings, 'MAISONPROOF_API_URL', '').rstrip('/')
    store = getattr(settings, 'MAISONPROOF_STORE_ID', '')
    if not base.startswith('https://') or not re.fullmatch(r'[A-Za-z0-9_-]{1,100}', store) or not sku:
        return ''
    url = f'{base}/v1/public/{quote(store, safe="")}/{quote(str(sku), safe="")}'
    try:
        with urlopen(Request(url, headers={'Accept': 'application/json'}), timeout=3) as response:
            data = json.load(response)
        if data.get('status') != 'authenticated':
            return ''
    except (OSError, ValueError, KeyError, TypeError):
        return ''
    return format_html('<span class="maisonproof-proof" aria-label="Independent authentication record available"><span class="maisonproof-proof__mark" aria-hidden="true">✓</span><strong class="maisonproof-proof__name">MAISONPROOF</strong> <span class="maisonproof-proof__status">Independently authenticated</span> <a href="{}" rel="noopener noreferrer" target="_blank">View record</a></span>', url)
