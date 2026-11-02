<?php
class Booking extends Model {
    const BASE = 'SELECT b.*, s.name AS service_name, s.price, u.name AS customer_name, u.email AS customer_email
                  FROM bookings b JOIN services s ON s.id=b.service_id JOIN users u ON u.id=b.user_id';

    public function isSlotTaken($serviceId, $date, $time) {
        $s = $this->db->prepare("SELECT COUNT(*) FROM bookings WHERE service_id=? AND booking_date=? AND booking_time=? AND status<>'cancelled'");
        $s->execute([$serviceId, $date, $time]);
        return $s->fetchColumn() > 0;
    }
    public function takenSlots($serviceId, $date) {
        $s = $this->db->prepare("SELECT TIME_FORMAT(booking_time,'%H:%i') FROM bookings WHERE service_id=? AND booking_date=? AND status<>'cancelled'");
        $s->execute([$serviceId, $date]);
        return $s->fetchAll(PDO::FETCH_COLUMN);
    }
    public function create($userId, $serviceId, $date, $time, $notes) {
        $s = $this->db->prepare('INSERT INTO bookings (user_id,service_id,booking_date,booking_time,notes) VALUES (?,?,?,?,?)');
        return $s->execute([$userId, $serviceId, $date, $time, $notes]);
    }
    public function find($id) {
        $s = $this->db->prepare(self::BASE . ' WHERE b.id = ?');
        $s->execute([$id]);
        return $s->fetch();
    }
    public function byUser($userId) {
        $s = $this->db->prepare(self::BASE . ' WHERE b.user_id=? ORDER BY b.booking_date DESC, b.booking_time DESC');
        $s->execute([$userId]);
        return $s->fetchAll();
    }
    public function all($status = '', $search = '') {
        $sql = self::BASE . ' WHERE 1=1';
        $p = [];
        if ($status !== '') { $sql .= ' AND b.status = ?'; $p[] = $status; }
        if ($search !== '') { $sql .= ' AND (u.name LIKE ? OR s.name LIKE ?)'; $p[] = "%$search%"; $p[] = "%$search%"; }
        $s = $this->db->prepare($sql . ' ORDER BY b.booking_date DESC, b.booking_time DESC');
        $s->execute($p);
        return $s->fetchAll();
    }
    public function updateStatus($id, $status) {
        $s = $this->db->prepare('UPDATE bookings SET status=? WHERE id=?');
        return $s->execute([$status, $id]);
    }
    public function cancelOwn($id, $userId) {
        $s = $this->db->prepare("UPDATE bookings SET status='cancelled' WHERE id=? AND user_id=? AND status IN ('pending','confirmed')");
        $s->execute([$id, $userId]);
        return $s->rowCount() > 0;
    }
    public function delete($id) {
        $s = $this->db->prepare('DELETE FROM bookings WHERE id=?');
        return $s->execute([$id]);
    }
    // ---- Reporting ----
    public function statusCounts() {
        $rows = $this->db->query('SELECT status, COUNT(*) c FROM bookings GROUP BY status')->fetchAll();
        $out = ['pending' => 0, 'confirmed' => 0, 'completed' => 0, 'cancelled' => 0];
        foreach ($rows as $r) $out[$r['status']] = (int)$r['c'];
        return $out;
    }
    public function revenue() {
        return (float)$this->db->query("SELECT COALESCE(SUM(s.price),0) FROM bookings b JOIN services s ON s.id=b.service_id WHERE b.status IN ('confirmed','completed')")->fetchColumn();
    }
    public function perService() {
        return $this->db->query("SELECT s.name, COUNT(b.id) total, COALESCE(SUM(CASE WHEN b.status IN ('confirmed','completed') THEN s.price END),0) revenue
                                 FROM services s LEFT JOIN bookings b ON b.service_id=s.id AND b.status<>'cancelled'
                                 GROUP BY s.id ORDER BY total DESC LIMIT 6")->fetchAll();
    }
    public function upcomingForUser($userId) {
        $s = $this->db->prepare("SELECT COUNT(*) FROM bookings WHERE user_id=? AND booking_date>=CURDATE() AND status IN ('pending','confirmed')");
        $s->execute([$userId]);
        return (int)$s->fetchColumn();
    }
}
