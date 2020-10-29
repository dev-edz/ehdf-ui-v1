<template>
    <div>
        <v-app-bar
            class="mb-2"
            elevation="0"
            dense>
            <v-tabs
                v-model="tab"
                slider-size="4">
                <v-tab class="font-weight-bold">
                    <v-icon class="mr-2">mdi-view-list</v-icon>
                    Transactions</v-tab>
                <v-tab class="font-weight-bold">
                    <v-icon class="mr-2">mdi-account-tie</v-icon>
                    Employees</v-tab>
            </v-tabs>
            <v-spacer></v-spacer>
        </v-app-bar>
        <v-tabs-items
            v-model="tab">
            <v-tab-item transition="fade-transition" reverse-transition="fade-transition">
                <transactions-component></transactions-component>
            </v-tab-item>
            <v-tab-item transition="fade-transition" reverse-transition="fade-transition">
                <employees-component></employees-component>
            </v-tab-item>
        </v-tabs-items>
    </div>
</template>
<script>
export default {
    data(){
        return {
            tab: 0,
        }
    }
}
</script>