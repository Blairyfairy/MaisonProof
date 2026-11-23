<?php
declare(strict_types=1);
namespace MaisonProof\Verification\Api;
interface LookupInterface { /** @param string $publicId @return string[] */ public function lookup(string $publicId): array; }
