<template>
    <v-layout>
        <v-flex shrink xs12>
            <RouterView />
        </v-flex>
    </v-layout>
</template>

<script>
    import Agendamiento from '../../../components/agendamiento/Agendamiento.vue'

    export default {
        name: 'Agendamiento',
        components: {
            Agendamiento
        },
        mounted(){
            this.setMenu();
        },
        methods:{
            setMenu(){
                this.$store.commit('setMenu', {
                    title: 'Módulo Agenda',
                    items: [
                        { name: 'Agenda', path: '/agenda', can:'agendas.enter' },
                        { name: 'Agendamiento Médico', path: '/agenda/agendamiento-medico',can:'agendamiento-medico.enter' },
                        { name: 'Reporte Agenda', path: '/agenda/reporte-agenda',can:'reporteAgenda.enter'},
                        // { name: 'Médicos', path: '/agenda/medicos',can:'medicos.enter' },
                    ],
                    enabled: true
                })
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>
