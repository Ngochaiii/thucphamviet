<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Support\AbstractRepository;
use Illuminate\Support\Facades\Hash;

class AuthRepository extends AbstractRepository
{
    public function model()
    {
        return User::class;
    }

    /**
     * Tìm user theo email
     */
    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    /**
     * Tạo user mới
     */
    public function createUser(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $data['display_name'] = $data['first_name'] . ' ' . $data['last_name'];
        $data['role'] = $data['role'] ?? 0; // Mặc định customer
        $data['is_active'] = $data['is_active'] ?? true;

        return $this->create($data);
    }

    /**
     * Cập nhật profile user
     */
    public function updateProfile($id, array $data)
    {
        if (isset($data['first_name']) && isset($data['last_name'])) {
            $data['display_name'] = $data['first_name'] . ' ' . $data['last_name'];
        }

        return $this->update($data, $id);
    }

    /**
     * Đổi mật khẩu
     */
    public function changePassword($id, $newPassword)
    {
        return $this->update([
            'password' => Hash::make($newPassword)
        ], $id);
    }

    /**
     * Lấy tất cả customers
     */
    public function getCustomers()
    {
        return $this->model->where('role', 0)->get();
    }

    /**
     * Lấy tất cả admins
     */
    public function getAdmins()
    {
        return $this->model->where('role', 1)->get();
    }

    /**
     * Lấy users active
     */
    public function getActiveUsers()
    {
        return $this->model->where('is_active', true)->get();
    }

    /**
     * Toggle active status
     */
    public function toggleActive($id)
    {
        return $this->toggle($id, 'is_active');
    }
}
