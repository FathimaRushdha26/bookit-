<?php
class Service extends Model {
    public function all($search = '', $category = '', $onlyActive = true) {
        $sql = 'SELECT * FROM services WHERE 1=1';
        $p = [];
        if ($onlyActive)  { $sql .= ' AND is_active = 1'; }
        if ($search !== '')   { $sql .= ' AND (name LIKE ? OR description LIKE ?)'; $p[] = "%$search%"; $p[] = "%$search%"; }
        if ($category !== '') { $sql .= ' AND category = ?'; $p[] = $category; }
        $s = $this->db->prepare($sql . ' ORDER BY name');
        $s->execute($p);
        return $s->fetchAll();
    }
    public function find($id) {
        $s = $this->db->prepare('SELECT * FROM services WHERE id = ?');
        $s->execute([$id]);
        return $s->fetch();
    }
    public function categories() {
        return $this->db->query('SELECT DISTINCT category FROM services ORDER BY category')->fetchAll(PDO::FETCH_COLUMN);
    }
    public function create($d) {
        $s = $this->db->prepare('INSERT INTO services (name,category,description,price,duration_minutes,is_active) VALUES (?,?,?,?,?,?)');
        return $s->execute([$d['name'], $d['category'], $d['description'], $d['price'], $d['duration'], $d['is_active']]);
    }
    public function update($id, $d) {
        $s = $this->db->prepare('UPDATE services SET name=?,category=?,description=?,price=?,duration_minutes=?,is_active=? WHERE id=?');
        return $s->execute([$d['name'], $d['category'], $d['description'], $d['price'], $d['duration'], $d['is_active'], $id]);
    }
    public function delete($id) {
        $s = $this->db->prepare('DELETE FROM services WHERE id = ?');
        return $s->execute([$id]);
    }
    public function count() {
        return (int)$this->db->query('SELECT COUNT(*) FROM services')->fetchColumn();
    }
}
