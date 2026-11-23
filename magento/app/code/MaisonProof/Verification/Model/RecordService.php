<?php
declare(strict_types=1);
namespace MaisonProof\Verification\Model;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Stdlib\DateTime\DateTime;
class RecordService {
 public function __construct(private ResourceConnection $resource, private DateTime $clock) {}
 public function byPublicId(string $id): ?array {
  if (!preg_match('/^[a-f0-9]{32}$/D', $id)) return null;
  $db=$this->resource->getConnection();$t=$this->resource->getTableName('maisonproof_record');
  $r=$db->fetchRow($db->select()->from($t)->where('public_id = ?', $id)->limit(1));return $r ?: null;
 }
 public function verifiedForProduct(int $productId): ?array {
  if ($productId <= 0) return null;
  $db=$this->resource->getConnection();$t=$this->resource->getTableName('maisonproof_record');
  $r=$db->fetchRow($db->select()->from($t)->where('product_id = ?', $productId)->where('status = ?', 'verified')->where('(expires_at IS NULL OR expires_at > ?)', $this->clock->gmtDate())->order('updated_at DESC')->limit(1));
  return $r ?: null;
 }
 public function publicStatus(array $r): string {
  if ($r['status'] === 'verified' && !empty($r['expires_at']) && strtotime((string)$r['expires_at']) <= time()) return 'expired';
  return in_array($r['status'], ['pending','verified','rejected','revoked','expired'], true) ? $r['status'] : 'unknown';
 }
 public function create(int $productId): string {
  if ($productId <= 0) throw new \InvalidArgumentException('Invalid product ID');
  $id=bin2hex(random_bytes(16));$this->resource->getConnection()->insert($this->resource->getTableName('maisonproof_record'), ['product_id'=>$productId,'public_id'=>$id,'status'=>'pending']);return $id;
 }
 public function update(int $recordId,string $status,?string $reviewer,?string $notes,?string $expiry): void {
  if (!in_array($status,['pending','verified','rejected','revoked'],true)) throw new \InvalidArgumentException('Invalid status');
  if ($expiry !== null && $expiry !== '' && strtotime($expiry) === false) throw new \InvalidArgumentException('Invalid expiry');
  $this->resource->getConnection()->update($this->resource->getTableName('maisonproof_record'),['status'=>$status,'reviewer'=>mb_substr((string)$reviewer,0,255),'notes'=>$notes,'expires_at'=>$expiry ?: null],['record_id = ?'=>$recordId]);
 }
 public function all(int $limit=100): array {
  $db=$this->resource->getConnection();return $db->fetchAll($db->select()->from($this->resource->getTableName('maisonproof_record'))->order('record_id DESC')->limit(min($limit,200)));
 }
}
