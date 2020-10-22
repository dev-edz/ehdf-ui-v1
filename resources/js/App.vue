<template>
    <v-app>
        <v-navigation-drawer
            v-model="drawer.isOpen"
            color=""
            dark
            width="180px"
            app
            clipped
            overflow
        >
            <v-list>
                <v-list-item
                    v-for="([text, icon, route], i) in drawer.navItems"
                    :key="i"
                    :to="route"
                    link
                >
                    <v-list-item-icon>
                        <v-icon>{{ icon }}</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>{{ text }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
        <v-app-bar 
            color="blue darken-1"
            app 
            clipped-left
            dense 
            dark
        >
            <v-app-bar-nav-icon
                @click.stop="drawer.isOpen = !drawer.isOpen"
            ></v-app-bar-nav-icon>
            <v-toolbar-title>POEA - Health Declaration Information Portal</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn 
                icon
                @click.stop="toggleTheme"
                primary
            >
                <v-icon>mdi-brightness-6</v-icon>
            </v-btn>
        </v-app-bar>

        <v-main>
            <router-view></router-view>
        </v-main>
        <v-footer app dark fixed height="25" class="pa-0">
            <v-col
                class="text-center pa-0"
                cols="12"
            >
                {{ new Date().getFullYear() }} — <strong>POEA - ICT</strong>
            </v-col>
        </v-footer>
    </v-app>
</template>
<script>
export default {
    data(){
        return {
            drawer: {
                isOpen: true,
                navItems: [
                    ['Dashboard', 'mdi-view-dashboard-outline', '/'],
                    ['Monitoring', 'mdi-clipboard-list-outline', '/monitoring'],
                    ['Users', 'mdi-account', '/users'],
                ]
            },
        }
    },
    methods: {
        toggleTheme(){
            this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
        },
    }
}
</script>
<style>
    a {
        text-decoration: none!important;
    }

    /* width */
    ::-webkit-scrollbar {
      width: 10px;
    }
    #nd-container::-webkit-scrollbar {
      display: none;
    }
    
    /* Track */
    ::-webkit-scrollbar-track {
      background: transparent;
      border-radius: 8px;
    }
     
    /* Handle */
    ::-webkit-scrollbar-thumb {
      background: #a5a5a5;
      border-radius: 8px;
    }
    
    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
      background: #555; 
    }
    html {
      overflow-y: auto;
    }
    body {
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -o-user-select: none;
        user-select: none;
    }

</style>