<template>
  <b-table bordered :fields="fields" :items="events" striped hover responsive>
    <template v-slot:cell(actions)="data">
      <b-button size="xs" variant="primary">
        Editar
      </b-button>
    </template>
    <template v-slot:cell(hourly)="data">
      <div v-for="item in data.item.hourly">
        {{ item.day }}: {{ item.hourly }} -
      </div>
    </template>
  </b-table>
</template>

<script>
export default {
  name: "eventsTable",
  props: ['events'],
  data() {
    return {
      fields: [
        {key: '', label: ''},
        {key: 'name', label: 'Nombre'},
        {key: 'typePersonal', label: 'Tipo de personal'},
        {key: 'initialDate', label: 'Fecha inicial'},
        {key: 'endDate', label: 'Fecha final'},
        {key: 'hourly', label: 'Hora'},
        {key: 'city', label: 'Ciudad'},
        {key: 'location', label: 'Lugar'},
        {key: 'address', label: 'Dirección'},
        {key: 'totalBudget', label: 'Presupuesto diario'},
        {key: 'totalBudget', label: 'Presupuesto total'},
        {key: 'status', label: 'Estado'},
        {key: 'actions', label: 'Acciones'},
      ]
    }
  }
}
</script>

<style scoped>

</style>
