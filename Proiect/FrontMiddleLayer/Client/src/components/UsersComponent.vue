<template>
  <!--<div class="hello">-->
    <!--&lt;!&ndash;<div class="test">&ndash;&gt;-->
        <!--&lt;!&ndash;<h3>{{test}}</h3>&ndash;&gt;-->
    <!--&lt;!&ndash;</div>&ndash;&gt;-->
      <v-form lazy-validation ref="registerform" v-model="valid">
          <v-container app>
              <v-layout wrap>
                  <v-flex xs12 md3>
                      <v-text-field
                              v-model="firstname"
                              :rules="firstNameRules"
                              :counter="30"
                              label="First name"
                              required
                      ></v-text-field>
                  </v-flex>
                  <v-flex xs12 md3>
                      <v-text-field
                              v-model="lastname"
                              :rules="nameRules"
                              :counter="15"
                              label="Last name"
                              required
                      ></v-text-field>
                  </v-flex>

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
                  <v-btn @click.prevent="register" large>Register</v-btn>
              </v-flex>
              </v-layout>
          </v-container>
      </v-form>
  <!--</div>-->
</template>

<script>
import UsersService from "../UsersService"
export default {
  name: 'UsersComponent',
  data() {
      return {
          valid: false,
          password:"",
          firstname: '',
          lastname: '',
          nameRules: [
              v => !!v || 'Last Name is required',
              v => v.length <= 30 || 'Last Name must be less or equal to 30 characters'
          ],
          firstNameRules: [
              v => !!v || 'First Name is required',
              v => v.length <= 15 || 'First Name must be less or equal to 15 characters'
          ],
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
        async register(){
            if(this.$refs.registerform.validate())
            {
                var user = {}
                user.firstname = this.firstname
                user.lastname = this.lastname
                user.email = this.email
                user.password = this.password
                console.log(user)
                var response = await UsersService.postUser(user)
//                console.log(response)
                if(response.status == 201)
                    {
                        alert("Success!")
                    }
            }
            
     },

    },
  created(){
      try{
          this.udata = UsersService.getUsers().then((data) => {
              console.log(data)
//              this.test = data
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
