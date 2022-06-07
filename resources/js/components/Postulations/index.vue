<template>
  <b-container>
    <b-card order-variant="light" header="EVENTOS" class="text-center">
      <b-card-body>
        <div class="text-end">
          <b-button @click="showModalEvents()" variant="primary">Crear convocatoria</b-button>
        </div>

        <!--============================
          COMPONENT TABLA
        ==============================-->
        <div class="mt-4">
          <eventsTable :events="events"/>
        </div>


      </b-card-body>
    </b-card>

    <!--============================
      MODAL EVENTS
    ==============================-->
    <b-modal hide-footer title="Registrar eventos" id="modal-event" size="lg">
      <formEvents @save="save"/>
    </b-modal>
  </b-container>

</template>

<script>
import formEvents from "./formEvents";
import eventsTable from "./eventsTable";

export default {
  name: "indexEvents",
  components: {
    formEvents,
    eventsTable
  },
  created() {
    this.getEvents();
  },
  data() {
    return {
      modalEvent: false,
      events: [],
    }
  },
  methods: {
    showModalEvents() {
      this.$bvModal.show('modal-event');
    },
    save(event) {
      this.createEvent(event).then(response => {
        this.events.push(response)
        toastr.success('Convocatoria creada');
        this.$bvModal.hide('modal-event');
      });
    },
    async createEvent(data) {
      const response = await axios.post('api/convocations', data);
      return Promise.resolve(response.data);
    },
    async getEvents() {
      const response = await axios.get('api/events');
      console.log(response.data)
      this.events = response.data;
    },

  }
}
</script>

<style scoped>

</style>
