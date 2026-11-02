<?php
class User extends Model {
    public function findByEmail($email) {
        $s = $this->db->prepare('SELECT * FROM users WHERE email = ?');
        $s->execute([$email]);
        return $s->fetch();
    }
    public function findById($id) {
        $s = $this->db->prepare('SELECT * FROM users WHERE id = ?');
        $s->execute([$id]);
        return $s->fetch();
    }
    public function create($name, $email, $phone, $password, $role = 'customer') {
        $s = $this->db->prepare('INSERT INTO users (name,email,phone,password,role) VALUES (?,?,?,?,?)');
        return $s->execute([$name, $email, $phone, password_hash($password, PASSWORD_BCRYPT), $role]);
    }
    public function all() {
        return $this->db->query("SELECT u.*, (SELECT COUNT(*) FROM bookings b WHERE b.user_id=u.id) AS total_bookings
                                 FROM users u ORDER BY u.created_at DESC")->fetchAll();
    }
    public function updateProfile($id, $name, $phone) {
        $s = $this->db->prepare('UPDATE users SET name=?, phone=? WHERE id=?');
        return $s->execute([$name, $phone, $id]);
    }
    public function updatePassword($id, $password) {
        $s = $this->db->prepare('UPDATE users SET password=? WHERE id=?');
        return $s->execute([password_hash($password, PASSWORD_BCRYPT), $id]);
    }
    public function delete($id) {
        $s = $this->db->prepare("DELETE FROM users WHERE id=? AND role='customer'");
        return $s->execute([$id]);
    }
    public function countCustomers() {
        return (int)$this->db->query("SELECT COUNT(*) FROM users WHERE role='customer'")->fetchColumn();
    }
}
