<template>
    <div>
        <v-navigation-drawer
                v-model="drawer"
                clipped
                fixed
                app
        >
            <v-list dense>
                <v-list-tile @click="loginRedirect">
                    <v-list-tile-action>
                        <v-icon>lock_open</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>Log in</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
                 <v-list-tile @click="registerRedirect">
                    <v-list-tile-action>
                        <v-icon>person_add</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>Register</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
                <v-list-tile @click="productsRedirect">
                    <v-list-tile-action>
                        <v-icon>restaurant_menu</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>Places</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
                <v-list-tile @click="">
                    <v-list-tile-action>
                        <v-icon>lock</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>Log out</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>
        </v-navigation-drawer>
        <v-toolbar app fixed clipped-left>
            <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
            <v-toolbar-title>QRit</v-toolbar-title>
        </v-toolbar>

        <v-footer app fixed>
            <span>&copy; 2017</span>
        </v-footer>
    </div>
</template>

<script>
    export default {
        name:"MenuComponent",
        data: () => ({
            drawer: null
        }),
        methods:{
            loginRedirect(){
                this.$store.commit('redirect', 1)
                //this.$store.state.showlogin=1-this.$store.state.showlogin;
            },
            registerRedirect(){
                this.$store.commit('redirect', 2)
                //this.$store.state.showlogin=1-this.$store.state.showlogin;
            },
            productsRedirect(){
                this.$store.commit('redirect', 3)
            }
        },
        props: {
            source: String
        }
    }
</script>