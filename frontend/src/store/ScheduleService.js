const STORAGE_KEY = 'schedules';

export const ScheduleService = {
  addSchedule: (schedule) => {
    const existingSchedules = JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];

    existingSchedules.push(schedule);

    localStorage.setItem(STORAGE_KEY, JSON.stringify(existingSchedules));
  },

  getSchedules: () => {
    return JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
  },
  editSchedule: (editedSchedule) => {
    const existingSchedules = JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];

    // Find the index of the Schedule to edit
    const indexToEdit = existingSchedules.findIndex(a => a.id === editedSchedule.id);

    // Replace the Schedule with the edited one
    if (indexToEdit !== -1) {
      existingSchedules[indexToEdit] = editedSchedule;
      localStorage.setItem(STORAGE_KEY, JSON.stringify(existingSchedules));
    }
  },

  deleteSchedule: (scheduleId) => {
    const existingSchedules = JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
    const indexToDelete = existingSchedules.findIndex(a => a.id === scheduleId);

    if (indexToDelete !== -1) {
      existingSchedules.splice(indexToDelete, 1);
      localStorage.setItem(STORAGE_KEY, JSON.stringify(existingSchedules));
    } else {
      console.error('Schedule not found');
      // Optionally, throw an error or handle the situation in a way that makes sense for your application
    }
  },
};
