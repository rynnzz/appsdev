<template>
    <q-header elevated class="header">
      <q-toolbar>
        <img src="~/src/assets/unnamed.png" alt="Logo">
        <h1>
          <span style="color: #ea4335;">CPC</span>
          <span style="color: #4285f4;">Safety Central</span>
        </h1>
        <div class="row" style="margin-left: 460px;">
          <q-badge v-if="notificationCount > 0" color="red" style="border-radius: 50%;">{{ notificationCount }}</q-badge>
          <!-- Notification dropdown button -->
          <q-btn-dropdown v-for="role in roles" v-if="userType === role.type" v-model="isNotificationDropdownVisible" :color="role.color" :icon="role.icon" class="text-white" :label="role.label" style="margin-right: 15px; align-items: center; width: 240px;">
            <q-list class="notification-dropdown">
              <q-item v-for="notification in notifications" :key="notification.id" clickable @click="scrollToNotification(notification)" ref="notificationItem">
                <q-item-section>
                  {{ notification.content }}
                  <br>
                  <br>
                  <p align="right">{{ notification.category }}</p>
                  <p align="right" v-if="notification.urgent == 1" style="color: red;">Urgent</p>
                  <q-item-section side top>
                    <q-badge v-if="!notification.read" color="red" label="New" />
                  </q-item-section>
                  <q-separator style="margin: 10px;"></q-separator>
                </q-item-section>
              </q-item>
            </q-list>
          </q-btn-dropdown>
          <!-- Logout button -->
          <q-btn type="button" class="btn btn-danger" @click="logout" style="width: 180px; border-radius: 30px;">
            <i class="mx-2">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"></path>
                <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"></path>
              </svg>
            </i>
            Sign Out
          </q-btn>
        </div>
        <!-- Navigation tabs -->
        <div class="nav-bar" style="margin-left: 70px;">
          <q-tabs>
            <li v-for="tab in tabs" :key="tab.to" class="nav-item list-unstyled" style="margin-right: 50px;">
              <router-link :to="tab.to" class="nav-link text-white" @click="setActiveTab(tab.name)" :class="{ active: activeTab === tab.name }">
                <i class="mx-1">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" :class="tab.icon" viewBox="0 0 16 16"></svg>
                </i>
                {{ tab.label }}
              </router-link>
            </li>
          </q-tabs>
        </div>
      </q-toolbar>
    </q-header>
  </template>
  
  <script>
  import { simulateLogout } from 'src/router/auth.js'
  export default {
    data() {
      return {
        roles: [
          { type: 'user', color: 'blue', icon: 'notifications', label: 'Notifications' },
          { type: 'teacher', color: 'green', icon: 'notifications', label: 'Notifications' },
          { type: 'admin', color: 'purple', icon: 'notifications', label: 'Notifications' }
        ],
        tabs: [
          { name: 'HomeComponent', to: '/HomeComponent', label: 'Home', icon: 'bi-house-fill3' },
          { name: 'AnnouncementsComponent', to: '/AnnouncementsComponent', label: 'Announcements', icon: 'bi-send-fill' },
          { name: 'SchedulesComponent', to: '/SchedulesComponent', label: 'Schedules', icon: 'bi-calendar-week-fill' },
          { name: 'ContactsComponent', to: '/ContactsComponent', label: 'Contacts', icon: 'bi-telephone-fill' },
          { name: 'StudentDirectoryComponent', to: '/StudentDirectoryComponent', label: 'Student Directory', icon: 'bi-person-vcard-fill', userType: ['admin', 'teacher'] },
          { name: 'ComposeComponent', to: '/ComposeComponent', label: 'Compose', icon: 'bi-rocket-takeoff-fill', userType: ['admin'] },
          { name: 'CreateTeacherAccount', to: '/CreateTeacherAccount', label: 'Create Teacher Account', icon: 'bi-person-fill-add', userType: ['admin'] },
          { name: 'ViewProfile', to: '/ViewProfile', label: 'View Profile', icon: 'bi-person-circle', userType: ['user'] }
        ]
      };
    },
    props: {
      notificationCount: Number,
      isNotificationDropdownVisible: Boolean,
      userType: String,
      activeTab: String,
      notifications: Array
    },
    methods: {
        setActiveTab(tabName) {
      this.$emit('update:activeTab', tabName);
    },
      logout() {
        simulateLogout();
        this.$router.push({ name: 'LoginComponent' });
      },
    }
  };
  </script>
  