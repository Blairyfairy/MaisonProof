<?php
declare(strict_types=1);
namespace MaisonProof\Verification\Model;
use MaisonProof\Verification\Api\LookupInterface;
class Lookup implements LookupInterface {
 public function __construct(private RecordService $records) {}
 public function lookup(string $publicId): array {
  $r=$this->records->byPublicId($publicId);
  if (!$r) return ['status'=>'not_found'];
  return ['status'=>$this->records->publicStatus($r),'public_id'=>$r['public_id'],'product_id'=>(string)$r['product_id'],'updated_at'=>(string)$r['updated_at'],'expires_at'=>(string)($r['expires_at'] ?? '')];
 }
}
