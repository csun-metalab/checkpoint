<template>
  <v-content>
    <v-container>
      <v-layout align-start justify-start fill-heigh>
        <v-flex md12>
          <h1>Sign Up</h1>
        </v-flex>
      </v-layout>
      <v-layout row wrap>
        <v-flex pa-1 grow>
          <v-form ref="form">
            <v-text-field v-model="organization" label="Organization Name" required></v-text-field>
            <v-text-field v-model="firstName" label="First Name" required></v-text-field>
            <v-text-field v-model="lastname" label="Last Name" required></v-text-field>
            <v-text-field v-model="email" label="E-mail (This will be your username)" required></v-text-field>
            <v-text-field type="password" v-model="password" label="Password" required></v-text-field>
            <v-text-field
              type="password"
              v-model="validatepassword"
              label="Re-Type Password"
              required
            ></v-text-field>
            <v-text-field v-model="address1" label="Address 1"></v-text-field>
            <v-text-field v-model="address2" label="Address 2"></v-text-field>
            <v-text-field v-model="city" label="City"></v-text-field>
            <v-text-field v-model="country" label="Country"></v-text-field>
            <v-text-field v-model="zip" label="Zip Code"></v-text-field>
            <v-btn color="primary">Submit</v-btn>
          </v-form>
        </v-flex>
        <v-flex pa-1 shrink>
          <v-btn color="blue-grey" class="white--text">Upload Logo
            <v-icon right dark>cloud_upload</v-icon>
          </v-btn>
        </v-flex>
      </v-layout>
    </v-container>
  </v-content>
</template>

<script>
import { required } from 'vuelidate/lib/validators';
export default {
  data: () => ({
    organization: null,
    firstName: null,
    lastname: null,
    email: null,
    password: null,
    validatepassword: null,
    address1: null,
    address2: null,
    city: null,
    country: null,
    zip: null
  }),
  validations: {
      form: {
          organization: { required },
          firstName: { required },
          lastName: { required },
          email: { required },
          password: { required },
          validatePassword: { required },
          address1: { required },
          address2: { required },
          city: { required },
          country: { required },
          zip: { required }
      }
  }
};
</script>
