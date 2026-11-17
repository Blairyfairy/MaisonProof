# MaisonProof for Django

Copy `maisonproof` into your Python path and add `maisonproof` to `INSTALLED_APPS`. Set `MAISONPROOF_API_URL` (HTTPS) and `MAISONPROOF_STORE_ID` in Django settings. In the product template load `{% load maisonproof %}`, add `{% load static %}` and `<link rel="stylesheet" href="{% static 'maisonproof/maisonproof.css' %}">`, then render `{% maisonproof_badge product.sku %}`. This is a display integration; merchant product syncing requires your application's integration.
