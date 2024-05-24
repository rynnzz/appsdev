import { checkIfUserIsAuthenticated } from './auth';

const routes = [
  {
    path: '/',
    name: 'LoginComponent',
    component: () => import('src/pages/LoginComponent.vue')
  },
  {
    path: '/RegisterComponent',
    name: 'RegisterComponent',
    component: () => import('src/pages/RegisterComponent.vue')
  },
  {
    path: '/HomeComponent',
    name: 'HomeComponent',
    component: () => import('src/pages/HomeComponent.vue'),
    beforeEnter: (to, from, next) => {
      if (checkIfUserIsAuthenticated()) {
        next();
      } else {
        next('/');
      }
    }
  },
  {
    path: '/AnnouncementsComponent',
    name: 'AnnouncementsComponent',
    component: () => import('src/pages/AnnouncementsComponent.vue'),
    beforeEnter: (to, from, next) => {
      if (checkIfUserIsAuthenticated()) {
        next();
      } else {
        next('/');
      }
    }
  },
  {
    path: '/SchedulesComponent',
    name: 'SchedulesComponent',
    component: () => import('src/pages/SchedulesComponent.vue'),
    beforeEnter: (to, from, next) => {
      if (checkIfUserIsAuthenticated()) {
        next();
      } else {
        next('/');
      }
    }
  },
  {
    path: '/ContactsComponent',
    name: 'ContactsComponent',
    component: () => import('src/pages/ContactsComponent.vue'),
    beforeEnter: (to, from, next) => {
      if (checkIfUserIsAuthenticated()) {
        next();
      } else {
        next('/');
      }
    }
  },
  {
    path: '/ViewProfile',
    name: 'ViewProfile',
    component: () => import('src/pages/ViewProfile.vue'),
    beforeEnter: (to, from, next) => {
      if (checkIfUserIsAuthenticated()) {
        next();
      } else {
        next('/');
      }
    }
  },
  {
    path: '/StudentDirectoryComponent',
    name: 'StudentDirectoryComponent',
    component: () => import('src/pages/StudentDirectoryComponent.vue'),
    beforeEnter: (to, from, next) => {
      if (checkIfUserIsAuthenticated()) {
        next();
      } else {
        next('/');
      }
    }
  },
  {
    path: '/ComposeComponent',
    name: 'ComposeComponent',
    component: () => import('src/pages/ComposeComponent.vue'),
    beforeEnter: (to, from, next) => {
      if (checkIfUserIsAuthenticated()) {
        next();
      } else {
        next('/');
      }
    },
  },
  {
    path: '/CreateTeacherAccount',
    name: 'CreateTeacherAccount',
    component: () => import('src/pages/CreateTeacherAccount.vue'),
    beforeEnter: (to, from, next) => {
      if (checkIfUserIsAuthenticated()) {
        next();
      } else {
        next('/');
      }
    }
  },
  {
    path: '/test',
    name: 'test',
    component: () => import('src/pages/test.vue')
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
]

export default routes
