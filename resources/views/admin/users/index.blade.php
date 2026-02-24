@extends('admin.layouts.admin')

@section('title', __('admin.users'))

@section('content')
<div class="mb-4" style="display: flex; justify-content: space-between; align-items: flex-end;">
    <div>
        <h2 class="page-title" style="margin-bottom: 5px;">{{ __('admin.users') }}</h2>
        <p class="page-subtitle" style="margin-bottom: 0;">{{ __('admin.manage_users') }}</p>
    </div>
    <button onclick="openAddUserModal()" style="background-color: #00D1FF; color: #fff; border: 1px solid #000; padding: 10px 20px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; display: flex; align-items: center; gap: 8px; box-shadow: 4px 4px 0px #000;">
        <i class="fa-solid fa-plus"></i> {{ __('admin.add_admin_officer') }}
    </button>
</div>

<!-- User Container -->
<div style="background-color: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 20px; margin-top: 20px;">
    
    <!-- Status Tabs -->
    <div style="background-color: var(--nav-hover-bg); padding: 6px; border-radius: 12px; width: fit-content; display: flex; gap: 5px; margin-bottom: 25px; border: 1px solid var(--border-color);">
        <button class="tab-btn active" data-role="all" style="padding: 8px 25px; border-radius: 10px; font-weight: 700; font-size: 13px; border: none; cursor: pointer; transition: all 0.3s; background: var(--bg-card); color: var(--text-title);">{{ __('admin.all') }} {{ __('admin.users') }}</button>
        <button class="tab-btn" data-role="Customer" style="padding: 8px 25px; border-radius: 10px; font-weight: 700; font-size: 13px; border: none; cursor: pointer; transition: all 0.3s; background: transparent; color: var(--text-muted);">{{ __('admin.role_customer') }}</button>
        <button class="tab-btn" data-role="Admin" style="padding: 8px 25px; border-radius: 10px; font-weight: 700; font-size: 13px; border: none; cursor: pointer; transition: all 0.3s; background: transparent; color: var(--text-muted);">{{ __('admin.role_admin') }}</button>
        <button class="tab-btn" data-role="Officer" style="padding: 8px 25px; border-radius: 10px; font-weight: 700; font-size: 13px; border: none; cursor: pointer; transition: all 0.3s; background: transparent; color: var(--text-muted);">{{ __('admin.role_officer') }}</button>
    </div>

    <!-- Table -->
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="border-bottom: 2px solid var(--border-color);">
                <th style="padding: 15px 10px; font-weight: 700; color: var(--text-title); font-size: 18px;">{{ __('admin.users') }}</th>
                <th style="padding: 15px 10px; font-weight: 700; color: var(--text-title); font-size: 18px;">{{ __('admin.role') }}</th>
                <th style="padding: 15px 10px; font-weight: 700; color: var(--text-title); font-size: 18px; text-align: center;">{{ __('admin.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="user-row" data-role="{{ ucfirst($user->role) }}" style="border-bottom: 1px solid var(--border-color);">
                <td style="padding: 20px 10px;">
                    <div style="font-weight: 700; color: var(--text-title); font-size: 15px;">{{ $user->name }}</div>
                    <div style="font-size: 12px; color: var(--text-muted);">{{ $user->email }}</div>
                </td>
                <td style="padding: 20px 10px; font-weight: 400; color: var(--text-main);">{{ __('admin.role_' . strtolower($user->role)) }}</td>
                <td style="padding: 20px 10px; text-align: center;">
                    <div style="display: flex; justify-content: center; align-items: center; gap: 15px;">
                        <a href="javascript:void(0)" onclick='openEditRoleModal({!! json_encode(["id" => $user->id, "name" => $user->name, "role" => __("admin.role_" . strtolower($user->role))]) !!})' style="color: var(--text-main); font-size: 20px;"><i class="fa-regular fa-pen-to-square"></i></a>
                        <a href="javascript:void(0)" onclick='openDeleteModal({!! json_encode(["id" => $user->id, "name" => $user->name]) !!})' style="color: #EE4444; font-size: 20px;"><i class="fa-solid fa-trash-can"></i></a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add User Modal -->
<div id="addUserModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1000; backdrop-filter: blur(4px);">
    <div style="background: #fff; width: 500px; border-radius: 20px; position: relative; border: 2px solid #000; box-shadow: 10px 10px 0px #000; padding: 40px;">
        <button onclick="closeAddUserModal()" style="position: absolute; right: 20px; top: 20px; background: none; border: none; font-size: 24px; cursor: pointer; color: #000;">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h3 style="font-size: 24px; font-weight: 800; color: #000; margin-bottom: 20px; text-transform: uppercase;">{{ __('admin.add_admin_officer') }}</h3>

        @if($errors->any())
        <div style="background: #FEB2B2; border: 2px solid #000; border-radius: 12px; padding: 15px; margin-bottom: 25px; box-shadow: 4px 4px 0px #000;">
            <ul style="margin: 0; padding-left: 20px; color: #C53030; font-weight: 700; font-size: 13px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route($routePrefix . '.users.store') }}" method="POST" id="addUserForm">
            @csrf
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 12px; font-weight: 800; color: #000; margin-bottom: 8px; text-transform: uppercase;">{{ __('admin.full_name') }}</label>
                <input type="text" name="name" placeholder="{{ __('admin.full_name') }}" required style="width: 100%; padding: 12px 15px; border: 2px solid #000; border-radius: 12px; font-size: 14px; box-sizing: border-box; font-weight: 700;">
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 12px; font-weight: 800; color: #000; margin-bottom: 8px; text-transform: uppercase;">{{ __('admin.email_address') }}</label>
                <input type="email" name="email" placeholder="email@example.com" required style="width: 100%; padding: 12px 15px; border: 2px solid #000; border-radius: 12px; font-size: 14px; box-sizing: border-box; font-weight: 700;">
            </div>
            <div style="margin-bottom: 20px; position: relative;">
                <label style="display: block; font-size: 12px; font-weight: 800; color: #000; margin-bottom: 8px; text-transform: uppercase;">{{ __('admin.system_role') }}</label>
                <select name="role" required style="width: 100%; padding: 12px 15px; border: 2px solid #000; border-radius: 12px; font-size: 14px; background: #fff; appearance: none; font-weight: 700;">
                    <option value="admin">{{ __('admin.role_admin') }}</option>
                    <option value="officer">{{ __('admin.role_officer') }}</option>
                </select>
                <div style="position: absolute; right: 20px; top: 43px; pointer-events: none;">
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
            </div>
            <div style="margin-bottom: 30px;">
                <label style="display: block; font-size: 12px; font-weight: 800; color: #000; margin-bottom: 8px; text-transform: uppercase;">{{ __('admin.set_password') }}</label>
                <input type="password" name="password" placeholder="••••••••" required style="width: 100%; padding: 12px 15px; border: 2px solid #000; border-radius: 12px; font-size: 14px; box-sizing: border-box; font-weight: 700;">
            </div>
            <button type="submit" style="width: 100%; background: #FFEA00; color: #000; border: 2px solid #000; padding: 14px; border-radius: 50px; font-weight: 800; font-size: 16px; cursor: pointer; box-shadow: 4px 4px 0px #000; text-transform: uppercase;">
                {{ __('admin.create_account') }}
            </button>
        </form>
    </div>
</div>

<!-- Edit Role Modal -->
<div id="editRoleModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1000; backdrop-filter: blur(4px);">
    <div style="background: #fff; width: 450px; border-radius: 20px; position: relative; border: 2px solid #000; box-shadow: 10px 10px 0px #000; padding: 40px;">
        <button onclick="closeEditRoleModal()" style="position: absolute; right: 20px; top: 20px; background: none; border: none; font-size: 24px; cursor: pointer; color: #000;">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h3 style="font-size: 24px; font-weight: 800; color: #000; margin-bottom: 30px; text-transform: uppercase;">{{ __('admin.edit_user_info') }}</h3>

        <form action="#" method="POST" onsubmit="event.preventDefault(); closeEditRoleModal(); showSuccess('User information updated successfully!');">
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 12px; font-weight: 800; color: #000; margin-bottom: 8px; text-transform: uppercase;">{{ __('admin.users') }}</label>
                <div id="edit_user_name" style="width: 100%; padding: 12px 15px; border: 2px solid #000; border-radius: 12px; font-size: 15px; color: #000; background: #F7FAFC; font-weight: 700;">
                    User Name
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 12px; font-weight: 800; color: #000; margin-bottom: 8px; text-transform: uppercase;">{{ __('admin.role') }}</label>
                <div id="edit_user_role_label" style="width: 100%; padding: 12px 15px; border: 2px solid #000; border-radius: 12px; font-size: 15px; color: #000; background: #F7FAFC; font-weight: 700;">
                    Role Name
                </div>
            </div>

            <div style="margin-bottom: 35px;">
                <label style="display: block; font-size: 12px; font-weight: 800; color: #000; margin-bottom: 8px; text-transform: uppercase;">Update Password</label>
                <input type="password" id="edit_user_password" placeholder="Leave blank to keep current" style="width: 100%; padding: 12px 15px; border: 2px solid #000; border-radius: 12px; font-size: 14px; box-sizing: border-box; font-weight: 700;">
            </div>

            <button type="submit" style="width: 100%; background: #FFEA00; color: #000; border: 2px solid #000; padding: 14px; border-radius: 50px; font-weight: 800; font-size: 16px; cursor: pointer; box-shadow: 4px 4px 0px #000; text-transform: uppercase;">
                {{ __('admin.save_changes') }}
            </button>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1000; backdrop-filter: blur(4px);">
    <div style="background: #fff; width: 400px; border-radius: 20px; position: relative; border: 2px solid #000; box-shadow: 10px 10px 0px #000; padding: 40px; text-align: center;">
        <div style="width: 80px; height: 80px; background: #FFEA00; border: 2px solid #000; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; box-shadow: 4px 4px 0px #000;">
            <i class="fa-solid fa-trash-can" style="font-size: 35px; color: #000;"></i>
        </div>
        <h3 style="font-size: 22px; font-weight: 800; color: #000; margin-bottom: 10px; text-transform: uppercase;">{{ __('admin.are_you_sure') }}</h3>
        <p style="font-size: 15px; color: #4A5568; margin-bottom: 30px; line-height: 1.5; font-weight: 600;">{!! __('admin.delete_confirmation_user', ['name' => '<span id="delete_user_name" style="font-weight: 800; color: #000;"></span>']) !!}</p>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <button onclick="closeDeleteModal()" style="background: #fff; color: #000; border: 2px solid #000; padding: 12px; border-radius: 50px; font-weight: 800; font-size: 14px; cursor: pointer; text-transform: uppercase; border: 2px solid #000;">{{ __('admin.cancel') }}</button>
            <button onclick="confirmDelete()" style="background: #EE4444; color: #fff; border: 2px solid #000; padding: 12px; border-radius: 50px; font-weight: 800; font-size: 14px; cursor: pointer; text-transform: uppercase; box-shadow: 4px 4px 0px #000;">{{ __('admin.yes_delete') }}</button>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1100; backdrop-filter: blur(4px);">
    <div style="background: #fff; width: 400px; border-radius: 20px; position: relative; border: 2px solid #000; box-shadow: 10px 10px 0px #000; padding: 40px; text-align: center;">
        <div style="width: 80px; height: 80px; background: #4ADE80; border: 2px solid #000; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; box-shadow: 4px 4px 0px #000;">
            <i class="fa-solid fa-check" style="font-size: 40px; color: #000;"></i>
        </div>
        <h3 style="font-size: 22px; font-weight: 800; color: #000; margin-bottom: 10px; text-transform: uppercase;">{{ __('admin.success') }}</h3>
        <p id="successMessage" style="font-size: 15px; color: #4A5568; margin-bottom: 30px; line-height: 1.5; font-weight: 600;">{{ __('admin.operation_success') }}</p>
        <button onclick="closeSuccessModal()" style="width: 100%; background: #FFEA00; color: #000; border: 2px solid #000; padding: 12px; border-radius: 50px; font-weight: 800; font-size: 16px; cursor: pointer; box-shadow: 4px 4px 0px #000; text-transform: uppercase;">
            Great!
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            showSuccess("{{ session('success') }}");
        @endif

        @if($errors->any())
            openAddUserModal();
        @endif
    });

    // Tab Filtering Logic
    const tabButtons = document.querySelectorAll('.tab-btn');
    const userRows = document.querySelectorAll('.user-row');

    tabButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            tabButtons.forEach(b => {
                b.classList.remove('active');
                b.style.background = 'transparent';
                b.style.color = 'var(--text-muted)';
            });
            btn.classList.add('active');
            btn.style.background = 'var(--bg-card)';
            btn.style.color = 'var(--text-title)';

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
        currentDeleteId = user.id;
        document.getElementById('delete_user_name').innerText = user.name;
        document.getElementById('deleteModal').style.display = 'flex';
    }
    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    function confirmDelete() {
        if (currentDeleteId) {
            const form = document.getElementById('deleteUserForm');
            const route = "{{ route($routePrefix . '.users.destroy', ':id') }}";
            form.action = route.replace(':id', currentDeleteId);
            form.submit();
        }
    }

    let currentDeleteId = null;

    function showSuccess(message) {
        document.getElementById('successMessage').innerText = message;
        document.getElementById('successModal').style.display = 'flex';
    }
    function closeSuccessModal() {
        document.getElementById('successModal').style.display = 'none';
    }
</script>
    <form id="deleteUserForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection
