<template>
    <div id="single-dashboard_wrapper" v-if="dashboard" :style="{backgroundImage: `url('/${dashboard.background}')`}">
        <h1 class="text-left dashboard-title">{{ dashboard.title }}</h1>

        <draggable id="columns"
                   v-model="columns"
                   class="d-flex"
                   group="columns"
                   draggable=".column-wrapper">

            <column-list v-for="column in columns" :key="column.id" :column="column"/>

            <div class="column-btn_wrapper" slot="footer">
                <router-link class="btn  btn-sm btn-primary width-100"
                             :to="{name: 'columnCreate'}">
                    Add column
                </router-link>
            </div>

        </draggable>

        <router-view/>
    </div>
</template>

<script>
    import {mapActions, mapState, mapGetters} from 'vuex'
    import draggable from 'vuedraggable'
    import ColumnList from "./ColumnList";

    export default {
        name: "SingleDashboard",

        components: {
            draggable,
            ColumnList
        },

        mounted() {
            this.loadSingleDashboard(this.$route.params)

            this.channel = this.$pusher.subscribe(`private-dashboard.${this.$route.params.id}`)

            this.channel.bind('TaskHasBeenSorted', (e) => {
                this.taskHasBeenSorted(e.column)
            })

        },

        data() {
            return {
                channel: null
            }
        },

        computed: {
            ...mapState('dashboards', ['dashboard']),

            columns: {
                get() {
                    return this.$store.state.column.columns;
                },
                set(newSetColumns) {
                    // todo change to dispatch
                    this.$store.dispatch('column/sortColumn', newSetColumns)
                }
            },
        },

        methods: {
            ...mapActions('dashboards', ['loadSingleDashboard']),
            ...mapActions('column', ['taskHasBeenSorted']),
        }
    }
</script>
