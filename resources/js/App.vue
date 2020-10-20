<template>
    <v-app>
        <v-navigation-drawer
            v-model="drawer.isOpen"
            color="blue"
            dark
            width="200px"
            app
            clipped
            overflow
        >
            <v-list 
                nav>
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
            <v-toolbar-title>POEA - electronic Health Declaration Form Portal</v-toolbar-title>
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
            <router-view class="px-2"></router-view>
        </v-main>
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
                    ['Logs', 'mdi-clipboard-list-outline', '/logs'],
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
    .v-list-item--link {
        text-decoration: none!important;
    }

</style>