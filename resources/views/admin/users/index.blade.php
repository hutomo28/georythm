@extends('admin.layouts.admin')

@section('title', 'User')

@section('content')
<div class="mb-4" style="display: flex; justify-content: space-between; align-items: flex-end;">
    <div>
        <h2 class="page-title" style="margin-bottom: 5px;">User</h2>
        <p class="page-subtitle" style="margin-bottom: 0;">Manage system users and roles</p>
    </div>
    <button onclick="openAddUserModal()" style="background-color: #00D1FF; color: #fff; border: 1px solid #000; padding: 10px 20px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; display: flex; align-items: center; gap: 8px; box-shadow: 4px 4px 0px #000;">
        <i class="fa-solid fa-plus"></i> Add Admin/Officer
    </button>
</div>

<!-- User Container -->
<div style="background-color: #fff; border: 1px solid #000; border-radius: 12px; padding: 20px; margin-top: 20px;">
    
    <!-- Status Tabs -->
    <div style="background-color: #E2E8F0; padding: 6px; border-radius: 12px; width: fit-content; display: flex; gap: 5px; margin-bottom: 25px; border: 1px solid #000;">
        <button class="tab-btn active" data-role="all" style="padding: 8px 25px; border-radius: 10px; font-weight: 700; font-size: 13px; border: none; cursor: pointer; transition: all 0.3s; background: #fff; color: #000;">All User</button>
        <button class="tab-btn" data-role="Customer" style="padding: 8px 25px; border-radius: 10px; font-weight: 700; font-size: 13px; border: none; cursor: pointer; transition: all 0.3s; background: transparent; color: #4A5568;">Customer</button>
        <button class="tab-btn" data-role="Admin" style="padding: 8px 25px; border-radius: 10px; font-weight: 700; font-size: 13px; border: none; cursor: pointer; transition: all 0.3s; background: transparent; color: #4A5568;">Admin</button>
        <button class="tab-btn" data-role="Officer" style="padding: 8px 25px; border-radius: 10px; font-weight: 700; font-size: 13px; border: none; cursor: pointer; transition: all 0.3s; background: transparent; color: #4A5568;">Officer</button>
    </div>

    <!-- Table -->
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="border-bottom: 2px solid #000;">
                <th style="padding: 15px 10px; font-weight: 700; color: #000; font-size: 18px;">User</th>
                <th style="padding: 15px 10px; font-weight: 700; color: #000; font-size: 18px;">Role</th>
                <th style="padding: 15px 10px; font-weight: 700; color: #000; font-size: 18px; text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @php
                $users = [
                    ['name' => 'Bagoes Hutomo', 'email' => 'bagoeshutomo@gmail.com', 'role' => 'Admin'],
                    ['name' => 'Kim Jong-un', 'email' => 'kimkim@gmail.com', 'role' => 'Customer'],
                    ['name' => 'Dewi Anjani', 'email' => 'jani@gmail.com', 'role' => 'Officer'],
                    ['name' => 'Maha Meru', 'email' => 'semeru@gmail.com', 'role' => 'Customer'],
                    ['name' => 'Aji Saka', 'email' => 'sadu@gmail.com', 'role' => 'Officer'],
                ];
            @endphp

            @foreach($users as $user)
            <tr class="user-row" data-role="{{ $user['role'] }}" style="border-bottom: 1px solid #E2E8F0;">
                <td style="padding: 20px 10px;">
                    <div style="font-weight: 700; color: #000; font-size: 15px;">{{ $user['name'] }}</div>
                    <div style="font-size: 12px; color: #718096;">{{ $user['email'] }}</div>
                </td>
                <td style="padding: 20px 10px; font-weight: 400; color: #000;">{{ $user['role'] }}</td>
                <td style="padding: 20px 10px; text-align: center;">
                    <div style="display: flex; justify-content: center; align-items: center; gap: 15px;">
                        <a href="javascript:void(0)" onclick="openEditRoleModal({{ json_encode($user) }})" style="color: #000; font-size: 20px;"><i class="fa-regular fa-pen-to-square"></i></a>
                        <a href="javascript:void(0)" onclick="openDeleteModal({{ json_encode($user) }})" style="color: #EE4444; font-size: 20px;"><i class="fa-solid fa-trash-can"></i></a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add User Modal -->
<div id="addUserModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1000; backdrop-filter: blur(4px);">
    <div style="background: #fff; width: 500px; border-radius: 12px; position: relative; border: 1px solid #000; box-shadow: 10px 10px 0px #000; padding: 40px;">
        <button onclick="closeAddUserModal()" style="position: absolute; right: 20px; top: 20px; background: none; border: none; font-size: 24px; cursor: pointer; color: #000;">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h3 style="font-size: 24px; font-weight: 800; color: #000; margin-bottom: 30px; text-transform: uppercase;">Add Admin/Officer</h3>

        <form action="#" method="POST" onsubmit="event.preventDefault(); closeAddUserModal(); showSuccess('User added successfully!');">
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 14px; font-weight: 700; color: #000; margin-bottom: 8px; text-transform: uppercase;">Name</label>
                <input type="text" placeholder="Full Name" style="width: 100%; padding: 12px 15px; border: 1px solid #000; border-radius: 8px; font-size: 14px; box-sizing: border-box;">
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 14px; font-weight: 700; color: #000; margin-bottom: 8px; text-transform: uppercase;">Email</label>
                <input type="email" placeholder="email@example.com" style="width: 100%; padding: 12px 15px; border: 1px solid #000; border-radius: 8px; font-size: 14px; box-sizing: border-box;">
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 14px; font-weight: 700; color: #000; margin-bottom: 8px; text-transform: uppercase;">Role</label>
                <select style="width: 100%; padding: 12px 15px; border: 1px solid #000; border-radius: 8px; font-size: 14px; background: #fff;">
                    <option value="Admin">Admin</option>
                    <option value="Officer">Officer</option>
                </select>
            </div>
            <div style="margin-bottom: 30px;">
                <label style="display: block; font-size: 14px; font-weight: 700; color: #000; margin-bottom: 8px; text-transform: uppercase;">Password</label>
                <input type="password" placeholder="••••••••" style="width: 100%; padding: 12px 15px; border: 1px solid #000; border-radius: 8px; font-size: 14px; box-sizing: border-box;">
            </div>
            <button type="submit" style="width: 100%; background: #FFEA00; color: #000; border: 2px solid #000; padding: 14px; border-radius: 50px; font-weight: 800; font-size: 16px; cursor: pointer; box-shadow: 4px 4px 0px #000; text-transform: uppercase;">
                Create Account
            </button>
        </form>
    </div>
</div>

<!-- Edit Role Modal -->
<div id="editRoleModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1000; backdrop-filter: blur(4px);">
    <div style="background: #fff; width: 450px; border-radius: 12px; position: relative; border: 1px solid #000; box-shadow: 10px 10px 0px #000; padding: 40px;">
        <button onclick="closeEditRoleModal()" style="position: absolute; right: 20px; top: 20px; background: none; border: none; font-size: 24px; cursor: pointer; color: #000;">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h3 style="font-size: 24px; font-weight: 800; color: #000; margin-bottom: 30px; text-transform: uppercase;">Edit User Info</h3>

        <form action="#" method="POST" onsubmit="event.preventDefault(); closeEditRoleModal(); showSuccess('User information updated successfully!');">
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 14px; font-weight: 700; color: #000; margin-bottom: 8px; text-transform: uppercase;">User</label>
                <div id="edit_user_name" style="width: 100%; padding: 12px 15px; border: 1px solid #000; border-radius: 8px; font-size: 15px; color: #4A5568; background: #F7FAFC; font-weight: 600;">
                    User Name
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 14px; font-weight: 700; color: #000; margin-bottom: 8px; text-transform: uppercase;">Role</label>
                <div id="edit_user_role_label" style="width: 100%; padding: 12px 15px; border: 1px solid #000; border-radius: 8px; font-size: 15px; color: #4A5568; background: #F7FAFC; font-weight: 600;">
                    Role Name
                </div>
            </div>

            <div style="margin-bottom: 35px;">
                <label style="display: block; font-size: 14px; font-weight: 700; color: #000; margin-bottom: 8px; text-transform: uppercase;">Update Password</label>
                <input type="password" id="edit_user_password" placeholder="Leave blank to keep current" style="width: 100%; padding: 12px 15px; border: 1px solid #000; border-radius: 8px; font-size: 14px; box-sizing: border-box;">
            </div>

            <button type="submit" style="width: 100%; background: #FFEA00; color: #000; border: 2px solid #000; padding: 14px; border-radius: 50px; font-weight: 800; font-size: 16px; cursor: pointer; box-shadow: 4px 4px 0px #000; text-transform: uppercase;">
                Save Changes
            </button>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1000; backdrop-filter: blur(4px);">
    <div style="background: #fff; width: 400px; border-radius: 12px; position: relative; border: 1px solid #000; box-shadow: 10px 10px 0px #000; padding: 40px; text-align: center;">
        <div style="width: 80px; height: 80px; background: #FFEA00; border: 2px solid #000; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; box-shadow: 4px 4px 0px #000;">
            <i class="fa-solid fa-trash-can" style="font-size: 35px; color: #000;"></i>
        </div>
        <h3 style="font-size: 22px; font-weight: 800; color: #000; margin-bottom: 10px; text-transform: uppercase;">Are you sure?</h3>
        <p style="font-size: 15px; color: #4A5568; margin-bottom: 30px; line-height: 1.5;">You are about to delete user <span id="delete_user_name" style="font-weight: 700; color: #000;"></span>. This action cannot be undone.</p>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <button onclick="closeDeleteModal()" style="background: #fff; color: #000; border: 2px solid #333; padding: 12px; border-radius: 50px; font-weight: 800; font-size: 14px; cursor: pointer; text-transform: uppercase;">No, Cancel</button>
            <button onclick="confirmDelete()" style="background: #EE4444; color: #fff; border: 2px solid #000; padding: 12px; border-radius: 50px; font-weight: 800; font-size: 14px; cursor: pointer; text-transform: uppercase; box-shadow: 4px 4px 0px #000;">Yes, Delete</button>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1100; backdrop-filter: blur(4px);">
    <div style="background: #fff; width: 400px; border-radius: 12px; position: relative; border: 1px solid #000; box-shadow: 10px 10px 0px #000; padding: 40px; text-align: center;">
        <div style="width: 80px; height: 80px; background: #4ADE80; border: 2px solid #000; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; box-shadow: 4px 4px 0px #000;">
            <i class="fa-solid fa-check" style="font-size: 40px; color: #000;"></i>
        </div>
        <h3 style="font-size: 22px; font-weight: 800; color: #000; margin-bottom: 10px; text-transform: uppercase;">Success!</h3>
        <p id="successMessage" style="font-size: 15px; color: #4A5568; margin-bottom: 30px; line-height: 1.5;">Operation completed successfully.</p>
        <button onclick="closeSuccessModal()" style="width: 100%; background: #FFEA00; color: #000; border: 2px solid #000; padding: 12px; border-radius: 50px; font-weight: 800; font-size: 16px; cursor: pointer; box-shadow: 4px 4px 0px #000; text-transform: uppercase;">
            Great!
        </button>
    </div>
</div>

<script>
    // Tab Filtering Logic
    const tabButtons = document.querySelectorAll('.tab-btn');
    const userRows = document.querySelectorAll('.user-row');

    tabButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            tabButtons.forEach(b => {
                b.classList.remove('active');
                b.style.background = 'transparent';
                b.style.color = '#4A5568';
            });
            btn.classList.add('active');
            btn.style.background = '#fff';
            btn.style.color = '#000';

            const role = btn.getAttribute('data-role');
            userRows.forEach(row => {
                if (role === 'all' || row.getAttribute('data-role') === role) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });

    // Modal Functions
    function openAddUserModal() {
        document.getElementById('addUserModal').style.display = 'flex';
    }
    function closeAddUserModal() {
        document.getElementById('addUserModal').style.display = 'none';
    }

    function openEditRoleModal(user) {
        document.getElementById('edit_user_name').innerText = user.name;
        document.getElementById('edit_user_role_label').innerText = user.role;
        document.getElementById('edit_user_password').value = '';
        document.getElementById('editRoleModal').style.display = 'flex';
    }
    function closeEditRoleModal() {
        document.getElementById('editRoleModal').style.display = 'none';
    }

    function openDeleteModal(user) {
        document.getElementById('delete_user_name').innerText = user.name;
        document.getElementById('deleteModal').style.display = 'flex';
    }
    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    function confirmDelete() {
        closeDeleteModal();
        showSuccess('User deleted successfully!');
    }

    function showSuccess(message) {
        document.getElementById('successMessage').innerText = message;
        document.getElementById('successModal').style.display = 'flex';
    }
    function closeSuccessModal() {
        document.getElementById('successModal').style.display = 'none';
    }
</script>
@endsection
