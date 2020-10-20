<template>
    <div id="Logs">
        <v-row class="mx-auto">
            <v-col 
                cols="8">
                <v-card outlined>
                    <v-card-title>
                        Logs
                    </v-card-title>
                    <v-card-text>
                        <v-data-table
                            :headers="dataTable.headers"
                            :items="dataTable.items"
                            fixed-header
                            hover
                            height="72vh"
                            outline
                        >
                            
                        </v-data-table>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="4">
                <v-card outlined>
                    <v-card-title>
                        Latest Entry
                    </v-card-title>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>
<script>
export default {
    data(){
        return {
            
            dataTable: {
                headers: [
                    {
                        text: 'No.',
                        align: 'center',
                        sortable: true,
                        value: 'id',
                        divider: true
                    },
                    {
                        text: 'Fullname',
                        align: 'start',
                        sortable: false,
                        value: 'applicant',
                        divider: true
                    },
                    {
                        text: 'Office',
                        align: 'start',
                        sortable: true,
                        value: 'office',
                        divider: true
                    },
                    {
                        text: 'Date & Time',
                        align: 'center',
                        sortable: false,
                        value: 'date_time',
                        divider: false
                    },
                ],
                items: [
                    { id: 1, applicant: 'Eduardo M. Lazaro III', office: 'POEA', date_time: 'date time now' }
                ]
            }
        }
    }
}
</script>