const STORAGE_KEY = 'announcements';

export const AnnouncementService = {
  addAnnouncement: (announcement) => {
    const existingAnnouncements = JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];

    existingAnnouncements.push(announcement);

    localStorage.setItem(STORAGE_KEY, JSON.stringify(existingAnnouncements));
  },


  getAnnouncements: () => {
    return JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
  },

  editAnnouncement: (editedAnnouncement) => {
    const existingAnnouncements = JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];

    // Find the index of the announcement to edit
    const indexToEdit = existingAnnouncements.findIndex(a => a.id === editedAnnouncement.id);

    // Replace the announcement with the edited one
    if (indexToEdit !== -1) {
      editedAnnouncement.date = existingAnnouncements[indexToEdit].date;
      existingAnnouncements[indexToEdit] = editedAnnouncement;
      localStorage.setItem(STORAGE_KEY, JSON.stringify(existingAnnouncements));
    }
  },
  updateAnnouncement: (updatedAnnouncement) => {
    const existingAnnouncements = JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];

    // Find the index of the announcement to update
    const indexToUpdate = existingAnnouncements.findIndex(a => a.id === updatedAnnouncement.id);

    // Update the announcement with the new content
    if (indexToUpdate !== -1) {
      existingAnnouncements[indexToUpdate].content = updatedAnnouncement.content;
      existingAnnouncements[indexToUpdate].date = updatedAnnouncement.date;
      localStorage.setItem(STORAGE_KEY, JSON.stringify(existingAnnouncements));
    } else {
      console.error('Announcement not found');
      // Optionally, throw an error or handle the situation in a way that makes sense for your application
    }
  },

  deleteAnnouncement: (announcementId) => {
    const existingAnnouncements = JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
    const indexToDelete = existingAnnouncements.findIndex(a => a.id === announcementId);

    if (indexToDelete !== -1) {
      existingAnnouncements.splice(indexToDelete, 1);
      localStorage.setItem(STORAGE_KEY, JSON.stringify(existingAnnouncements));
    } else {
      console.error('Announcement not found');
      // Optionally, throw an error or handle the situation in a way that makes sense for your application
    }
  },
};
