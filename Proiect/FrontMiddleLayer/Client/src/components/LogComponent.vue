<template>
          <v-container app>
            <v-form lazy-validation ref="loginform" v-model="valid"/>
              <v-layout wrap>
                 
                  <v-flex xs12 md3>
                      <v-text-field
                              v-model="email"
                              :rules="emailRules"
                              :counter="50"
                              label="E-mail"
                              required
                      ></v-text-field>
                  </v-flex>

                  <v-flex xs12 md3>
                      <v-text-field
                              v-model="password"
                              :rules="passwordRules"
                              :counter="50"
                              label="Password"
                              :type="'password'"
                              required
                      ></v-text-field>
                  </v-flex>
              <v-flex>
                  <v-btn @click.prevent="login" large>Log In</v-btn>
              </v-flex>
              </v-layout>
            </v-form>
          </v-container>
</template>

<script>
import UsersService from "../UsersService"
export default {
  name: 'LogComponent',
  data() {
      return {
          valid: false,
          password:"",
          email: '',
          emailRules: [
              v => !!v || 'E-mail is required',
              v => /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(v) || 'E-mail must be valid'
          ],
          passwordRules: [
              v => !!v || "Password is required",
              v => v.length >= 8 || "Password must have at least 8 characters",
              v => /[0-9]+/.test(v) || "Password must contain at least 1 digit",
              v => v.length <= 50 || "Password must be less or equal to 50 characters"
          ],
          data:{},
          test:"",
      }
  },
    methods:{
        login(){
            if(this.$refs.loginrform.validate())
            {

            }
     },

    },
  created(){
      try{
          this.udata = UsersService.getUsers().then((data) => {
              console.log(data)
              this.test = data
              //alert("done1") 
          })
      }
      catch(err)
      {
          console.log(err)
      }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h3 {
  margin: 40px 0 0;
    color: #42b983;}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>
