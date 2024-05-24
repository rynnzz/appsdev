<template>
  <header>
    <img src="~/src/assets/sticker.jpg" alt="Logo">
    <h1>
      <span style="color: #ea4335;">Cordova</span> <span style="color: #4285f4;">Public College</span>
    </h1>
  </header>

  <body>
    <h2>Safeguarded, Smart, and<br> Effortless Safety Hub</h2>
    <q-form @submit.prevent="register">
      <q-card class="register-form">
        <q-card-section>
          <div class="form-container">
            <br>
            <div v-if="errorMessage" class="text-danger">{{ errorMessage }}</div>
            <input v-model="id_num" type="text" id="id_num" class="id" name="id_num" placeholder="ID Number"
              required><br><br>

            <input v-model="fname" type="text" id="fname" class="fname" name="fname" placeholder="First Name"
              required><br><br>

            <input v-model="mname" type="text" id="mname" class="mname" name="mname" placeholder="Middle Name"
              required><br><br>

            <input v-model="lname" type="text" id="lname" class="lname" name="lname" placeholder="Last Name"
              required><br><br>

            <input v-model="address" type="text" id="address" class="address" name="address" placeholder="Address"
              required><br><br>

            <div v-if="passwordMatchError" class="text-danger">{{ passwordMatchError }}</div>

            <input v-model="password" type="password" id="password" class="password" name="password"
              placeholder="Password" required><br><br>

            <input v-model="confirm_password" type="password" id="confirm_password" class="confirm_password"
              name="confirm_password" placeholder="Confirm Password" required><br><br>

            <input v-model="gname" type="text" id="gname" class="gname" name="gname" placeholder="Guardian/Parent Name"
              required><br><br>

            <input v-model="g_cnum" type="text" id="g_cnum" class="g_cnum" name="g_cnum"
              placeholder="Guardian/Parent Contact Number" required><br><br>

            <input v-model="s_cnum" type="text" id="s_cnum" class="s_cnum" name="s_cnum"
              placeholder="Student Contact Number" required><br><br>

            <input v-model="yr_and_sec" type="text" id="yr_and_sec" class="yr_and_sec" name="yr_and_sec"
              placeholder="Year and Section Format Example: 3C" required><br><br>

            <h5>Birth Date:</h5>
            <select v-model="birthMonth" id="birthMonth" class="b_date" style="width: 120px; margin-right: 15px;">
              <option v-for="(month, index) in months" :key="index + 1" :value="index + 1">{{ month }}</option>
            </select>

            <select v-model="birthDay" id="birthDay" class="b_date" style="width: 80px; margin-right: 15px;">
              <option v-for="day in days" :key="day" :value="day">{{ day }}</option>
            </select>

            <select v-model="birthYear" id="birthYear" class="b_date" style="width: 100px; margin-right: 15px;">
              <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
            </select><br><br><br>

            <select v-model="course" id="course"
              style="width: 250px; background: rgb(31, 32, 35); border: 1px solid rgb(60, 63, 68); border-radius: 10px; color: rgb(247, 248, 248); height: 46px;">
              <option value="" selected disabled>Course</option>
              <option value="BSIT">BSIT</option>
              <option value="BSHM">BSHM</option>
              <option value="BEED">BEED</option>
              <option value="BSED">BSED</option>
            </select><br><br>


            <q-btn type="submit" align="between" class="text-h7" color="green" label="Register" icon="person"
              style="width: 160px; margin-right: 50px;" />

            <q-btn type="button" class="btn btn-primary" @click="redirectToLogin"
              label="Already have an account? Go back to Login" style="width: 300px; height: 55px;" />
          </div>
        </q-card-section>
      </q-card>
    </q-form>
  </body>
  <q-dialog v-model="registrationSuccess" persistent>
    <q-card class="custom-card" style="width: 700px">
      <q-card-section>
        <div class="text-h6">Your registration was successful!</div>
      </q-card-section>
      <div class="footer" align="right" style="margin: 20px;">
        <button type="button" class="btn btn-success" @click="redirectToLogin" style="width: 150px;">Go to Login</button>
      </div>
    </q-card>
  </q-dialog>
</template>
<script>
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
import { checkIfUserIsAuthenticated } from 'src/router/auth'

export default {
  data() {
    const today = new Date();
    return {
      id_num: '',
      fname: '',
      mname: '',
      lname: '',
      address: '',
      age: '',
      b_date: '',
      password: '',
      confirm_password: '',
      gname: '',
      g_cnum: '',
      s_cnum: '',
      course: '',
      yr_and_sec: '',
      registrationSuccess: false,
      registrationError: '',
      passwordMatchError: '',
      errorMessage: '',
      birthDay: today.getDate(),
      birthMonth: today.getMonth() + 1,
      birthYear: today.getFullYear(),
      days: Array.from({ length: 31 }, (_, i) => i + 1),
      months: [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
      ],
      years: Array.from({ length: 100 }, (_, i) => new Date().getFullYear() - i),
    };
  },
  beforeRouteEnter(to, from, next) {
    if (checkIfUserIsAuthenticated()) {
      const userType = localStorage.getItem('userType')
      if (userType === 'admin') {
        next({ name: 'HomeComponent' })
      } else {
        next({ name: 'HomeComponent' })
      }
    } else {
      next()
    }
  },
  watch: {
    birthDay() {
      this.updateBDate();
    },
    birthMonth() {
      this.updateBDate();
    },
    birthYear() {
      this.updateBDate();
    },
  },
  methods: {
    async checkIdExists(id_num) {
      try {
        const response = await fetch('http://localhost/appsdev/backend/errorhandling.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            id_num: id_num
          })
        });

        if (!response.ok) {
          throw new Error('Network response was not ok');
        }

        const contentType = response.headers.get('content-type');

        if (contentType && contentType.includes('application/json')) {
          const responseData = await response.json();
          return responseData.exists;
        } else {
          throw new Error('Invalid response format. Expected JSON.');
        }
      } catch (error) {
        console.error('Error checking id_num:', error);
        throw new Error('An error occurred while checking id_num.');
      }
    },
    async register() {
      try {
        if (this.password !== this.confirm_password) {
          this.passwordMatchError = 'Password do not match.';
          return;
        } else {
          this.passwordMatchError = '';
        }

        const idExists = await this.checkIdExists(this.id_num);

        if (idExists) {
          throw new Error('ID Number already exists in the database.');
        }
        const response = await fetch('http://localhost/appsdev/backend/register.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            id_num: this.id_num,
            fname: this.fname,
            mname: this.mname,
            lname: this.lname,
            address: this.address,
            age: this.age,
            b_date: this.b_date,
            password: this.password,
            confirm_password: this.confirm_password,
            gname: this.gname,
            g_cnum: String(this.g_cnum),
            s_cnum: String(this.s_cnum),
            course: this.course,
            yr_and_sec: this.yr_and_sec,
            status: 'Enrolled'
          })
        })

        console.log('Response:', response)

        if (!response.ok) {

          throw new Error('Network response was not ok')
        }

        const contentType = response.headers.get('content-type')

        if (contentType && contentType.includes('application/json')) {
          const responseData = await response.json()

          if (responseData.success) {
            this.registrationSuccess = true;


          } else {
            this.registrationError = responseData.message || 'Unknown error during registration.'
          }
        } else {

          this.registrationError = 'Invalid response format. Expected JSON.'
        }
      } catch (error) {
        console.error('Error during registration:', error)
        this.registrationError = 'An error occurred during registration.'
        this.errorMessage = 'ID already Exists'
      }
    },
    calculateAge(birthDate) {
      const today = new Date();
      const birth = new Date(birthDate);
      let age = today.getFullYear() - birth.getFullYear();

      if (
        today.getMonth() < birth.getMonth() ||
        (today.getMonth() === birth.getMonth() && today.getDate() < birth.getDate())
      ) {
        age--;
      }

      this.age = age;
    },
    updateBDate() {
      if (this.birthDay && this.birthMonth && this.birthYear) {
        const formattedMonth = this.birthMonth.toString().padStart(2, '0');
        const formattedDay = this.birthDay.toString().padStart(2, '0');
        this.b_date = `${this.birthYear}-${formattedMonth}-${formattedDay}`;
        this.calculateAge(this.b_date);
      }
    },

    redirectToLogin() {
      this.$router.push('/')
    }
  }
}
</script>


<style scoped>
@import './css/register.css'
</style>
