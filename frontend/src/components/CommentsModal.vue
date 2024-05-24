<template>
    <q-dialog v-model="isVisible">
      <q-card>
        <q-card-section>
          <div class="text-h6">{{ componentType }} Comments</div>
        </q-card-section>
  
        <q-card-section>
          <div v-for="comment in comments" :key="comment.id" style="margin: 10px;">
            <p><strong>{{ comment.user }}:</strong> {{ comment.text }}</p>
            <p style="font-size: 12px; color: grey;">{{ new Date(comment.date).toLocaleString() }}</p>
          </div>
          <div style="margin-top: 10px;">
            <textarea v-model="newComment" placeholder="Add a comment" style="width: 100%; margin-bottom: 10px;"></textarea>
            <q-btn @click="addComment" color="primary" style="align-items: center; border-radius: 15px;">
              Add Comment
            </q-btn>
          </div>
        </q-card-section>
  
        <q-card-actions align="right">
          <q-btn flat label="Close" color="primary" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </template>
  
  <script>
  export default {
    props: {
      isVisible: Boolean,
      componentId: Number,
      componentType: String,
    },
    data() {
      return {
        comments: [],
        newComment: '',
      };
    },
    watch: {
      isVisible(newVal) {
        if (newVal) {
          this.fetchComments();
        }
      },
    },
    methods: {
      fetchComments() {
        fetch(`http://localhost/api/announcement.php?action=getComments&componentId=${this.componentId}&componentType=${this.componentType}`)
          .then(response => response.json())
          .then(data => {
            this.comments = data;
          })
          .catch(error => {
            console.error('Error fetching comments:', error);
          });
      },
      addComment() {
        if (this.newComment.trim() === '') return;
  
        const commentData = {
          action: 'addComment',
          componentId: this.componentId,
          componentType: this.componentType,
          user: this.$root.userFirstName, // Assuming you have a global user object
          text: this.newComment,
        };
  
        fetch('http://localhost/api/announcement.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(commentData),
        })
          .then(response => response.json())
          .then(data => {
            if (data.status === 'success') {
              this.comments.push({
                user: this.$root.userFirstName,
                text: this.newComment,
                date: new Date().toISOString(),
              });
              this.newComment = '';
            } else {
              console.error('Error adding comment:', data.message);
            }
          })
          .catch(error => {
            console.error('Error adding comment:', error);
          });
      },
    },
  };
  </script>
  