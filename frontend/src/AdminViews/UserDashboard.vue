<template>
  <div class="container pt-5">
    <div class="card card-primary">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
          <h3 class="card-title">Users</h3>
          <div>
            <button
                class="btn btn-primary mr-2"
                @click="openCreateModal"
            >
              <i class="fas fa-plus"></i> Create User
            </button>
            <button
                class="btn btn-secondary"
                @click="refreshUsers"
            >
              <i class="fas fa-sync-alt"></i> Refresh
            </button>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="user-table">
            <thead>
            <tr>
              <th>Name</th>
              <th>Role</th>
              <th>Email</th>
              <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="user in users" :key="user.id">
              <td>{{ user.name }}</td>
              <td>
                  <span class="role-badge" :class="getRoleClass(user.role_id)">
                    {{ getRoleName(user.role_id) }}
                  </span>
              </td>
              <td>{{ user.email || '-' }}</td>
              <td class="actions">
                <button
                    class="btn-action btn-edit"
                    @click="openEditModal(user)"
                >
                  <i class="fas fa-edit"></i>
                </button>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Create User Modal -->
    <div class="modal" :class="{ 'show': showCreateModal }">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Create New User</h5>
            <button type="button" class="close" @click="closeCreateModal">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="createUser">
              <div class="form-group">
                <label>Name</label>
                <input
                    v-model="newUser.name"
                    type="text"
                    class="form-control"
                    required
                >
              </div>
              <div class="form-group">
                <label>Email</label>
                <input
                    v-model="newUser.email"
                    type="email"
                    class="form-control"
                >
              </div>
              <div class="form-group">
                <label>Role</label>
                <select v-model="newUser.role_id" class="form-control" required>
                  <option value="1">Admin</option>
                  <option value="2">Librarian</option>
                  <option value="3" selected>User</option>
                </select>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="closeCreateModal">
                  Cancel
                </button>
                <button type="submit" class="btn btn-primary" :disabled="isCreating">
                  <span v-if="isCreating">Creating...</span>
                  <span v-else>Create User</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal" :class="{ 'show': showEditModal }">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit User</h5>
            <button type="button" class="close" @click="closeEditModal">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="updateUser">
              <div class="form-group">
                <label>Name</label>
                <input
                    v-model="editUserData.name"
                    type="text"
                    class="form-control"
                    required
                >
              </div>
              <div class="form-group">
                <label>Email</label>
                <input
                    v-model="editUserData.email"
                    type="email"
                    class="form-control"
                >
              </div>
              <div class="form-group">
                <label>Role</label>
                <select v-model="editUserData.role_id" class="form-control" required>
                  <option value="1">Admin</option>
                  <option value="2">Librarian</option>
                  <option value="3">User</option>
                </select>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="closeEditModal">
                  Cancel
                </button>
                <button type="submit" class="btn btn-primary" :disabled="isUpdating">
                  <span v-if="isUpdating">Updating...</span>
                  <span v-else>Update User</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Backdrop -->
    <div class="modal-backdrop" :class="{ 'show': showCreateModal || showEditModal }"></div>
  </div>
</template>

<script>
import usersApi from "@/api/usersApi";

export default {
  name: 'UsersDashboard',
  data() {
    return {
      users: [],
      showCreateModal: false,
      showEditModal: false,
      isCreating: false,
      isUpdating: false,
      newUser: {
        name: '',
        email: '',
        role_id: 3,
      },
      editUserData: {
        id: null,
        name: '',
        email: '',
        role_id: 3,
      }
    };
  },
  methods: {
    async fetchUsers() {
      try {
        this.users = await usersApi.getList();
      } catch (err) {
        console.error("Error fetching users:", err);
      }
    },
    refreshUsers() {
      this.fetchUsers();
    },
    openCreateModal() {
      this.showCreateModal = true;
    },
    closeCreateModal() {
      this.showCreateModal = false;
      this.resetNewUser();
    },
    openEditModal(user) {
      this.editUserData = {
        id: user.id,
        name: user.name,
        email: user.email,
        role_id: user.role_id,
      };
      this.showEditModal = true;
    },
    closeEditModal() {
      this.showEditModal = false;
      this.resetEditUser();
    },
    resetNewUser() {
      this.newUser = {
        name: '',
        email: '',
        role_id: 3,
      };
    },
    resetEditUser() {
      this.editUserData = {
        id: null,
        name: '',
        email: '',
        role_id: 3,
      };
    },
    async createUser() {
      this.isCreating = true;
      try {
        await usersApi.saveItem(this.newUser);
        this.closeCreateModal();
        this.fetchUsers();
      } catch (err) {
        console.error("Error creating user:", err);
      } finally {
        this.isCreating = false;
      }
    },
    async updateUser() {
      this.isUpdating = true;
      try {
        const payload = { ...this.editUserData };

        await usersApi.updateItem(this.editUserData.id, payload);
        this.closeEditModal();
        this.fetchUsers();
      } catch (err) {
        console.error("Error updating user:", err);
      } finally {
        this.isUpdating = false;
      }
    },
    getRoleName(roleId) {
      const roles = {
        1: 'Admin',
        2: 'Librarian',
        3: 'User'
      };
      return roles[roleId] || 'Unknown';
    },
    getRoleClass(roleId) {
      const roleClasses = {
        1: 'role-admin',
        2: 'role-librarian',
        3: 'role-user'
      };
      return roleClasses[roleId] || '';
    }
  },
  mounted() {
    this.fetchUsers();
  }
};
</script>

<style scoped>
/* Previous styles remain the same */

.container {
  max-width: 1200px;
  padding: 2rem 1rem;
}

.card {
  border: none;
  border-radius: 12px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
  overflow: hidden;
}

.card-primary {
  background-color: white;
  border: 1px solid #e2e8f0;
}

.card-header {
  background-color: white;
  border-bottom: 1px solid #e2e8f0;
  padding: 1.25rem 1.5rem;
}

.card-title {
  font-size: 1.25rem;
  font-weight: 600;
  color: #1e293b;
  margin: 0;
}

.card-body {
  padding: 1.5rem;
}

.table-responsive {
  overflow-x: auto;
}

.user-table {
  width: 100%;
  border-collapse: collapse;
}

.user-table th,
.user-table td {
  padding: 1rem;
  text-align: left;
  border-bottom: 1px solid #e2e8f0;
}

.user-table th {
  font-weight: 600;
  color: #1e293b;
  background-color: #f8fafc;
  text-transform: uppercase;
  font-size: 0.75rem;
  letter-spacing: 0.05em;
}

.user-table tr:hover td {
  background-color: #f8fafc;
}

.role-badge {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 600;
}

.role-admin {
  background-color: #fef2f2;
  color: #dc2626;
}

.role-librarian {
  background-color: #eff6ff;
  color: #2563eb;
}

.role-user {
  background-color: #ecfdf5;
  color: #059669;
}

.actions {
  display: flex;
  gap: 0.5rem;
}

.btn-action {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  border: none;
  cursor: pointer;
  transition: all 0.2s;
}

.btn-edit {
  background-color: rgba(59, 130, 246, 0.1);
  color: #3b82f6;
}

.btn-edit:hover {
  background-color: rgba(59, 130, 246, 0.2);
}

.btn-delete {
  background-color: rgba(239, 68, 68, 0.1);
  color: #ef4444;
}

.btn-delete:hover {
  background-color: rgba(239, 68, 68, 0.2);
}

.btn {
  padding: 0.625rem 1.25rem;
  border-radius: 8px;
  font-size: 0.9375rem;
  font-weight: 500;
  transition: all 0.2s ease;
  cursor: pointer;
  border: none;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
}

.btn-primary {
  background-color: #3b82f6;
  color: white;
}

.btn-primary:hover {
  background-color: #2563eb;
}

@media (max-width: 768px) {
  .user-table {
    display: block;
  }

  .user-table thead {
    display: none;
  }

  .user-table tr {
    display: block;
    margin-bottom: 1rem;
    border-bottom: 1px solid #e2e8f0;
  }

  .user-table td {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem;
  }

  .user-table td::before {
    content: attr(data-label);
    font-weight: 600;
    color: #64748b;
    margin-right: 1rem;
  }

  .actions {
    justify-content: flex-end;
  }
}

/* Modal Styles */
.modal {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 1050;
  overflow: hidden;
  outline: 0;
}

.modal.show {
  display: block;
}

.modal-dialog {
  position: relative;
  width: auto;
  margin: 1.75rem auto;
  max-width: 600px;
  pointer-events: none;
}

.modal-content {
  position: relative;
  display: flex;
  flex-direction: column;
  width: 100%;
  pointer-events: auto;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid rgba(0, 0, 0, 0.2);
  border-radius: 0.3rem;
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
  outline: 0;
}

.modal-header {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  padding: 1rem;
  border-bottom: 1px solid #e9ecef;
  border-top-left-radius: 0.3rem;
  border-top-right-radius: 0.3rem;
}

.modal-title {
  margin: 0;
  line-height: 1.5;
}

.modal-body {
  position: relative;
  flex: 1 1 auto;
  padding: 1rem;
}

.modal-footer {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  padding: 1rem;
  border-top: 1px solid #e9ecef;
}

.close {
  float: right;
  font-size: 1.5rem;
  font-weight: 700;
  line-height: 1;
  color: #000;
  text-shadow: 0 1px 0 #fff;
  opacity: 0.5;
  background: transparent;
  border: 0;
  cursor: pointer;
}

.close:hover {
  opacity: 0.75;
}

.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1040;
  width: 100vw;
  height: 100vh;
  background-color: #000;
  opacity: 0;
  transition: opacity 0.15s linear;
  pointer-events: none;
}

.modal-backdrop.show {
  opacity: 0.5;
  pointer-events: auto;
}

.form-group {
  margin-bottom: 1rem;
}

.form-control {
  display: block;
  width: 100%;
  padding: 0.375rem 0.75rem;
  font-size: 1rem;
  line-height: 1.5;
  color: #495057;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-control:focus {
  color: #495057;
  background-color: #fff;
  border-color: #80bdff;
  outline: 0;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

label {
  display: inline-block;
  margin-bottom: 0.5rem;
}

select.form-control {
  height: calc(2.25rem + 2px);
}

.mr-2 {
  margin-right: 0.5rem;
}
</style>