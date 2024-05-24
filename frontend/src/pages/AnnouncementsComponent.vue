<template>
  <q-layout>
    <q-page-container>
      <q-header elevated class="header">
        <q-toolbar>
          <img src="~/src/assets/unnamed.png" alt="Logo">
          <h1>
            <span style="color: #ea4335;">CPC</span> <span style="color: #4285f4;">Safety Central</span>
          </h1>
          <div class="row" style="margin-left: 810px; position: relative;">
            <div style="position: relative;">
              <q-btn flat round dense icon="notifications" aria-label="Notifications" @click="toggleNotifications" style="margin: 5px; align-items: center;"></q-btn>
              <span style="color: red; margin-right: 10px;" v-if="notificationCount > 0" class="notification-counter">{{ notificationCount }}</span>
            </div>
            <div v-if="notificationsOpen" class="notification-dropdown">
              <div v-if="notifications.length > 0">
                <div v-for="notification in notifications" :key="notification.id" class="notification-item" @click="navigateToPost(notification.selectedCategory)">
                  {{ notification.message }}
                </div>
              </div>
              <div v-else>
                No new notifications
              </div>
            </div>
            <q-btn type="button" class="btn btn-danger" @click="logout" style="width: 180px; border-radius: 30px;">
              <i class="mx-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                  <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                </svg>
              </i>
              Sign Out
            </q-btn>
          </div>
          <div class="nav-bar" style="margin-left: 70px;">
            <q-tabs>
              <li class="nav-item list-unstyled" style="margin-right: 50px;">
                <router-link to="/HomeComponent" class="nav-link text-white" @click="setActiveTab('HomeComponent')"
                  :class="{ active: activeTab === 'HomeComponent' }"><i class="mx-1"><svg
                      xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-house-fill3" viewBox="0 0 16 16">
                      <path
                        d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5Z" />
                      <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6Z" />
                    </svg></i>Home</router-link>
              </li>
              <li class="nav-item list-unstyled" style="margin-right: 50px;">
                <router-link to="/AnnouncementsComponent" class="nav-link text-white"
                  @click="setActiveTab('AnnouncementsComponent')"
                  :class="{ active: activeTab === 'AnnouncementsComponent' }"><i class="mx-1"><svg
                      xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-send-fill" viewBox="0 0 16 16">
                      <path
                        d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z" />
                    </svg></i>Announcements</router-link>
              </li>
              <li class="nav-item list-unstyled" style="margin-right: 50px;">
                <router-link to="/SchedulesComponent" class="nav-link text-white"
                  @click="setActiveTab('SchedulesComponent')" :class="{ active: activeTab === 'SchedulesComponent' }"><i
                    class="mx-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-calendar-week-fill" viewBox="0 0 16 16">
                      <path
                        d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2zM9.5 7h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm3 0h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zM2 10.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3.5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5z" />
                    </svg></i>Schedules</router-link>
              </li>
              <li class="nav-item list-unstyled" style="margin-right: 50px;">
                <router-link to="/ContactsComponent" class="nav-link text-white"
                  @click="setActiveTab('ContactsComponent')" :class="{ active: activeTab === 'ContactsComponent' }"><i
                    class="mx-1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-telephone-fill" viewBox="0 0 16 16">
                      <path fill-rule="evenodd"
                        d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                    </svg></i>Contacts</router-link>
              </li>
              <li class="nav-item list-unstyled" v-if="userType === 'user'">
                <router-link to="/ViewProfile" class="nav-link text-white" @click="setActiveTab('ViewProfile')"
                  :class="{ active: activeTab === 'ViewProfile' }"><i class="mx-2"><svg xmlns="http://www.w3.org/2000/svg"
                      width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                      <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                      <path fill-rule="evenodd"
                        d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                    </svg></i>View Profile</router-link>
              </li>
              <li class="nav-item list-unstyled" style="margin-right: 50px;" v-if="userType === 'admin'">
                <router-link to="/StudentDirectoryComponent" class="nav-link text-white"
                  @click="setActiveTab('StudentDirectoryComponent')"
                  :class="{ active: activeTab === 'StudentDirectoryComponent' }"><i class="mx-1"><svg
                      xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-person-vcard-fill" viewBox="0 0 16 16">
                      <path
                        d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5M9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8m1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5m-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96c.026-.163.04-.33.04-.5M7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0" />
                    </svg></i>Student Directory</router-link>
              </li>
              <li class="nav-item list-unstyled" style="margin-right: 50px;" v-if="userType === 'admin'">
                <router-link to="/ComposeComponent" class="nav-link text-white"
                  @click="setActiveTab('ComposeComponent')" :class="{ active: activeTab === 'ComposeComponent' }"><i
                    class="mx-1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-rocket-takeoff-fill" viewBox="0 0 16 16">
                      <path
                        d="M12.17 9.53c2.307-2.592 3.278-4.684 3.641-6.218.21-.887.214-1.58.16-2.065a3.578 3.578 0 0 0-.108-.563 2.22 2.22 0 0 0-.078-.23V.453c-.073-.164-.168-.234-.352-.295a2.35 2.35 0 0 0-.16-.045 3.797 3.797 0 0 0-.57-.093c-.49-.044-1.19-.03-2.08.188-1.536.374-3.618 1.343-6.161 3.604l-2.4.238h-.006a2.552 2.552 0 0 0-1.524.734L.15 7.17a.512.512 0 0 0 .433.868l1.896-.271c.28-.04.592.013.955.132.232.076.437.16.655.248l.203.083c.196.816.66 1.58 1.275 2.195.613.614 1.376 1.08 2.191 1.277l.082.202c.089.218.173.424.249.657.118.363.172.676.132.956l-.271 1.9a.512.512 0 0 0 .867.433l2.382-2.386c.41-.41.668-.949.732-1.526l.24-2.408Zm.11-3.699c-.797.8-1.93.961-2.528.362-.598-.6-.436-1.733.361-2.532.798-.799 1.93-.96 2.528-.361.599.599.437 1.732-.36 2.531Z" />
                      <path
                        d="M5.205 10.787a7.632 7.632 0 0 0 1.804 1.352c-1.118 1.007-4.929 2.028-5.054 1.903-.126-.127.737-4.189 1.839-5.18.346.69.837 1.35 1.411 1.925Z" />
                    </svg></i>Compose</router-link>
              </li>
              <li class="nav-item list-unstyled" v-if="userType === 'admin'">
                <router-link to="/CreateTeacherAccount" class="nav-link text-white"
                  @click="setActiveTab('CreateTeacherAccount')"
                  :class="{ active: activeTab === 'CreateTeacherAccount' }"><i class="mx-2"><svg
                      xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-person-fill-add" viewBox="0 0 16 16">
                      <path
                        d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                      <path
                        d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4" />
                    </svg></i>Create Teacher Account</router-link>
              </li>
            </q-tabs>
          </div>
        </q-toolbar>
      </q-header>
      <q-page class="body">
    <div align="center" style="margin: 20px;">
      <h2>Announcements</h2>
    </div>
    <div align="center" style="margin-bottom: 20px;">
      <input type="text" class="search-announcement" v-model="searchQuery" placeholder="Search Announcements" />
    </div>
    <div align="center">
      <q-card dark bordered class="bg-grey-10 my-card" align="left" style="width: 700px; margin: 50px;">
        <div>
          <div v-if="filteredAnnouncements.length > 0">
            <div v-for="announcement in filteredAnnouncements" :key="announcement.id" class="announcement">
              <p class="announcement-content">{{ announcement.content }}</p>
              <br>
              <p class="announcement-date" align="right">Date Posted: {{ announcement.date }}</p>
              <p class="announcement-urgent" align="right" v-if="announcement.urgent">Urgent</p>
              <div v-if="userType === 'admin'">
                <q-btn @click="editAnnouncement(announcement)" color="orange" class="edit-btn">Edit</q-btn>
                <q-btn @click="deleteAnnouncement(announcement)" color="danger" class="delete-btn">Delete</q-btn>
              </div>
              <div class="reactions-section">
    <div class="reactions-summary">
      <button @click="toggleReaction(announcement.id)" class="fa fa-heart reaction-icon" id="reaction-button"></button> {{ reactions[announcement.id]?.Love || 0 }}
    </div>
  </div>
              <q-separator dark />
              <div class="comments-section">
                <h3>Comments</h3>
                <div v-for="(comment, index) in comments[announcement.id]" :key="comment.id" class="comment">
                  <p style="font-size: 20px">{{ comment.user }}: {{ comment.content }} <br> <span style="font-size:12px;">{{ formatRelativeTime(comment.date) }}</span></p>
                </div>
                <div class="add-comment-section">
                  <input v-model="newComment[announcement.id]" @keyup.enter="addComment(announcement.id, 'announcement')" placeholder="Add a comment" class="comment-input" />
                  <button type="button" @click="addComment(announcement.id, 'announcement')" class="comment-input">Add Comment</button>
                </div>
              </div>
            </div>
          </div>
          <div v-else>
            <p style="margin: 20px;">No announcement found.</p>
          </div>
        </div>
      </q-card>
    </div>
  </q-page>

    </q-page-container>
  </q-layout>
  <q-dialog v-model="isDeleteConfirmationModalVisible" persistent>

    <q-card class="custom-card" style="width: 100vw">
      <q-card-section>
        <h2 class="text-h6">
          Confirm Deletion
        </h2>
      </q-card-section>

      <q-card-section>
        <p>Are you sure you want to delete this announcement?</p>
      </q-card-section>

      <q-card-actions align="right" style="margin: 20px;">

        <q-btn color="primary" @click="cancelDelete"
          style="align-items: center; margin-right: 10px; border-radius: 15px;">
          Cancel
        </q-btn>

        <q-btn color="negative" @click="confirmDelete" style="align-items: center; border-radius: 15px;">
          Delete
        </q-btn>

      </q-card-actions>

    </q-card>

  </q-dialog>
  <q-dialog v-model="isEditModalVisible" persistent>

    <q-card class="custom-card" style="width: 300vw;">

      <q-card-section>
        <h2 class="text-h6">Edit Announcement</h2>
      </q-card-section>

      <q-card-section>
        <textarea v-model="editedAnnouncement.content" placeholder="Announcement" class="compose" />

        <input type="date" v-model="editedAnnouncement.date" class="date" />

      </q-card-section>

      <q-card-actions align="right" style="margin: 20px;">

        <q-btn label="Cancel" color="primary" @click="cancelEdit"
          style="align-items: center; margin-right: 10px; border-radius: 15px;" />

        <q-btn label="Save Changes" color="positive" @click="saveChanges"
          style="align-items: center; width: 160px; border-radius: 15px;" />

      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { simulateLogout } from 'src/router/auth'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
import dayjs from 'dayjs'
import relativeTime from 'dayjs/plugin/relativeTime'

dayjs.extend(relativeTime)

export default {
  data() {
    return {
      activeTab: 'AnnouncementsComponent',
      notifications: [],
      isDeleteConfirmationModalVisible: false,
      announcements: [],
      isEditModalVisible: false,
      announcementToDeleteId: null,
      comments: {},
      notifications: [],
      notificationsOpen: false,
      notificationCount: 0,
      newComment: {},
      editedAnnouncement: {
        id: '',
        content: '',
        date: '',
        urgent: 0,
      },
      isCommentsModalVisible: false,
      modalComments: [],
      currentPostId: null,
      searchQuery: '',
      reactions: {},
      userReactions: {},
    };
  },

  created() {
    this.initializeData();
  },

  methods: {
  async initializeData() {
    await this.getAnnouncements();
    await this.loadCommentsForAllAnnouncements();
    await this.loadReactionsForAllAnnouncements();
  },

  async loadReactionsForAllAnnouncements() {
    for (let announcement of this.announcements) {
      await this.getReactions(announcement.id);
    }
  },

  async getReactions(postId) {
    try {
      const response = await fetch('http://localhost/appsdev/backend/reactions.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          action: 'getReactions',
          post_id: postId,
          user: this.userFirstName
        }),
      });

      if (response.ok) {
        const data = await response.json();
        this.reactions = { ...this.reactions, [postId]: data.reactions };
        this.userReactions = { ...this.userReactions, [postId]: data.userReaction };
      } else {
        const errorMessage = await response.json();
        console.error('Error fetching reactions:', errorMessage);
      }
    } catch (error) {
      console.error('Error fetching reactions:', error);
    }
  },

  async toggleReaction(postId) {
    if (this.userReactions[postId] === 'Love') {
      await this.removeReaction(postId);
    } else {
      await this.addReaction(postId, 'Love');
    }
  },

  async addReaction(postId, reaction) {
    try {
      const response = await fetch('http://localhost/appsdev/backend/reactions.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          action: 'addReaction',
          post_id: postId,
          user: this.userFirstName,
          reaction: reaction,
        }),
      });
      if (response.ok) {
        await this.getReactions(postId);
      } else {
        const errorMessage = await response.json();
        console.error('Error adding reaction:', errorMessage);
      }
    } catch (error) {
      console.error('Error adding reaction', error);
    }
  },

  async removeReaction(postId) {
    try {
      const response = await fetch('http://localhost/appsdev/backend/reactions.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          action: 'deleteReaction',
          post_id: postId,
          user: this.userFirstName,
        }),
      });
      if (response.ok) {
        await this.getReactions(postId);
      } else {
        const errorMessage = await response.json();
        console.error('Error removing reaction:', errorMessage);
      }
    } catch (error) {
      console.error('Error removing reaction', error);
    }
  },


    async addComment(postId, category) {
      try {
        const response = await fetch('http://localhost/appsdev/backend/posts.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            action: 'addComment',
            post_id: postId,
            category: category,
            user: this.userFirstName,
            content: this.newComment[postId],
          }),
        });
        if (response.ok) {
          this.newComment[postId] = '';
          await this.getComments(postId, category);
        } else {
          const errorMessage = await response.json();
          console.error('Error adding comment:', errorMessage);
        }
      } catch (error) {
        console.error('Error adding comment', error);
      }
    },

    async getComments(postId, category) {
      try {
        const response = await fetch('http://localhost/appsdev/backend/posts.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            action: 'getComments',
            post_id: postId,
            category: category
          }),
        });

        if (response.ok) {
          const comments = await response.json();
          this.comments = { ...this.comments, [postId]: comments };
        } else {
          const errorMessage = await response.json();
          console.error('Error fetching comments:', errorMessage);
        }
      } catch (error) {
        console.error('Error fetching comments:', error);
      }
    },

    async loadCommentsForAllAnnouncements() {
      for (let announcement of this.announcements) {
        await this.getComments(announcement.id, 'announcement');
      }
    },
    
    async fetchNotifications() {
      try {
        const response = await fetch('http://localhost/appsdev/backend/notifications.php');
        if (response.ok) {
          this.notifications = await response.json();
          this.notificationCount = this.notifications.length; // Update notification count
        } else {
          console.error('Error fetching notifications:', response.statusText);
        }
      } catch (error) {
        console.error('Error fetching notifications:', error);
      }
    },
    
    toggleNotifications() {
      this.notificationsOpen = !this.notificationsOpen;
      if (this.notificationsOpen) {
        this.fetchNotifications();
      }
    },
    
    resetNotificationCount() {
      this.notificationCount = 0;
    },
    
    navigateToPost(selectedCategory) {
      this.notificationsOpen = false;
      this.resetNotificationCount();
  
      // Navigate based on selectedCategory
      if (selectedCategory === 'AnnouncementsComponent') {
        this.$router.push({ name: 'AnnouncementsComponent' });
      } else if (selectedCategory === 'SchedulesComponent') {
        this.$router.push({ name: 'SchedulesComponent' });
      } else if (selectedCategory === 'ContactsComponent') {
        this.$router.push({ name: 'ContactsComponent' });
      } else {
        this.$router.push({ name: 'AnnouncementsComponent' });
      }
    },
    
    clearDialog() {
      this.showDialog = false;
    },

    async getAnnouncements() {
      try {
        const response = await fetch('http://localhost/appsdev/backend/posts.php?action=getAnnouncements');

        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const data = await response.json(); // Parse the JSON response

        this.announcements = data.map(announcement => ({
          ...announcement,
        }));

        // this.notifications = this.announcements.filter(a => a.urgent === 1);

      } catch (error) {
        console.error('Error fetching announcements', error);
      }
    },

    formatRelativeTime(date) {
      return dayjs(date).fromNow();
    },

    setActiveTab(tab) {
      this.activeTab = tab;
    },

    toggleNotificationDropdown() {
      this.isNotificationDropdownVisible = !this.isNotificationDropdownVisible;
    },

    logout() {
      simulateLogout();
      this.$router.push({ name: 'LoginComponent' });
    },

    deleteAnnouncement(announcement) {
      this.announcementToDeleteId = announcement.id;
      this.isDeleteConfirmationModalVisible = true;
    },

    cancelDelete() {
      this.isDeleteConfirmationModalVisible = false;
    },

    async confirmDelete() {
      try {
        const response = await fetch('http://localhost/appsdev/backend/posts.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            action: 'deleteAnnouncement',
            id: this.announcementToDeleteId,
            category: this.announcements.find(a => a.id === this.announcementToDeleteId).category,
          }),
        });
        if (response.ok) {
          this.announcements = this.announcements.filter(a => a.id !== this.announcementToDeleteId);
          this.announcementToDeleteId = null;
          this.isDeleteConfirmationModalVisible = false;
        } else {
          const errorMessage = await response.json();
          console.error('Error deleting announcement:', errorMessage);
        }
      } catch (error) {
        console.error('Error deleting announcement', error);
      }
    },

    editAnnouncement(announcement) {
      this.editedAnnouncement = {
        id: announcement.id,
        content: announcement.content,
        date: new Date(announcement.date).toISOString().slice(0, 10),
        urgent: announcement.urgent,
      };
      this.announcementToDeleteId = announcement.id;
      this.isEditModalVisible = true;
    },

    cancelEdit() {
      this.editedAnnouncement.id = null;
      this.editedAnnouncement.content = '';
      this.editedAnnouncement.date = '';
      this.announcementToDeleteId = null;
      this.isEditModalVisible = false;
    },

    async saveChanges() {
      try {
        const editedDate = new Date(this.editedAnnouncement.date);
        const formattedDate = `${editedDate.getFullYear()}-${(editedDate.getMonth() + 1).toString().padStart(2, '0')}-${editedDate.getDate().toString().padStart(2, '0')}`;

        const response = await fetch('http://localhost/appsdev/backend/posts.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            action: 'updateAnnouncement',
            id: this.editedAnnouncement.id,
            content: this.editedAnnouncement.content,
            date: formattedDate,
            urgent: this.editedAnnouncement.urgent,
            category: this.announcements.find(a => a.id === this.editedAnnouncement.id)?.category || 'Announcement',
          }),
        });

        if (response.ok) {
          const index = this.announcements.findIndex(a => a.id === this.editedAnnouncement.id);
          if (index !== -1) {
            this.announcements.splice(index, 1, {
              id: this.editedAnnouncement.id,
              content: this.editedAnnouncement.content,
              date: this.editedAnnouncement.date,
              urgent: this.editedAnnouncement.urgent,
            });
          }
          this.editedAnnouncement.id = null;
          this.isEditModalVisible = false;
        } else {
          const errorMessage = await response.json();
          console.error('Error updating announcement:', errorMessage);
        }
      } catch (error) {
        console.error('Error updating announcement', error);
      }
    },

  },

  computed: {
    userFirstName() {
      const userData = sessionStorage.getItem('userData');
      const userType = sessionStorage.getItem('userType');
      
      if (userData && userType) {
        const userObject = JSON.parse(userData);

        if (userType === 'admin') {
          return userObject.username;
        }
        else if (userType === 'teacher') {
          return userObject.fname;
        } else {
          return userObject.fname;
        }
      }

      return null;
    },
    userType() {
      return sessionStorage.getItem('userType');
    },

    computedAnnouncements() {
      const sortedAnnouncements = this.announcements.slice().sort((a, b) => b.urgent - a.urgent);
      return sortedAnnouncements.map(announcement => {
        const formattedDate = new Date(announcement.date).toLocaleDateString('en-US', {
          month: 'long',
          day: 'numeric',
          year: 'numeric',
          timeZone: 'UTC',
        });
        return { ...announcement, date: formattedDate };
      });
    },
    filteredAnnouncements() {
      if (!this.searchQuery) {
        return this.announcements;
      }
      const query = this.searchQuery.toLowerCase();
      const filtered = this.announcements.filter(announcement =>
        announcement.content.toLowerCase().includes(query) ||
        announcement.date.toLowerCase().includes(query)
      );

      return filtered;
    }
  },
};
</script>
<style scoped>
@import './css/announcement.css'
</style>
