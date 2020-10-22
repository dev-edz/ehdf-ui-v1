<template>
    <div id="Users">
        <v-container fluid>
            <v-card class="mx-auto" height="75vh" outlined>
                <v-card-title class="green pa-2 ma-2 white--text justify-center">USER TABLE</v-card-title>
                <v-card-text>
                    <v-data-table
                        class="table-striped text-uppercase"
                        :headers="dataTable.headers"
                        :items="dataTable.items"
                        :loading="loading"
                        :items-per-page="-1"
                        fixed-header
                        hover
                        height="60vh"
                        outline
                    >
                    </v-data-table>
                </v-card-text>
            </v-card>
        </v-container>
    </div>
</template>
<script>
export default {
    data(){
        return {
            loading: false,
            dataTable: {
                headers: [
                    {
                        text: 'No',
                        align: 'center',
                        sortable: false,
                        value: 'id',
                        divider: true,
                        width: '10%',
                    },
                    {
                        text: 'Fullname',
                        align: 'start',
                        sortable: false,
                        value: 'fullname',
                        divider: true
                    },
                    {
                        text: 'Office',
                        align: 'center',
                        sortable: true,
                        value: 'Office',
                        divider: true
                    },
                    {
                        text: 'Date & Time',
                        align: 'center',
                        sortable: false,
                        value: 'DateCreated',
                        divider: false,
                        width: '20%',
                    },
                ],
                items: [],
                refreshInterval: '',
            }
        }
    },
}
</script>