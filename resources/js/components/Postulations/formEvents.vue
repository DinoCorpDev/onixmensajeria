<template>
  <ValidationObserver v-slot="{ handleSubmit }">
    <b-form @submit.prevent="handleSubmit(submit)">

      <b-alert show variant="warning">
        <pre><code>{{ event.hourly }}</code></pre>
      </b-alert>

      <b-form-group
          label="idItalentt"
          class="mt-4">
        <b-form-input
            type="text"
            v-model="event.idItalentt">
        </b-form-input>
      </b-form-group>

      <ValidationProvider name="nombre" rules="required" v-slot="{ errors }">
        <b-form-group
            label="Nombre completo"
            class="mt-4">
          <b-form-input
              type="text"
              v-model="event.name">
          </b-form-input>
          <span class="text-danger">{{ errors[0] }}</span>
        </b-form-group>
      </ValidationProvider>


      <div class="mt-4">
        <label for="formFileMultiple" class="form-label">Banner</label>
        <input @change="(e)=>bannerUpload(e.target.files)" class="form-control" type="file" id="formFileMultiple">
      </div>


      <ValidationProvider name="tipo de personal" rules="required" v-slot="{ errors }">
        <b-form-group
            label="Tipo de Personal"
            class="mt-4">
          <b-form-select class="form-select"
                         v-model="event.typePersonal"
                         :options="options">
          </b-form-select>
          <span class="text-danger">{{ errors[0] }}</span>
        </b-form-group>
      </ValidationProvider>

      <ValidationProvider name="fecha inicial" rules="required" v-slot="{ errors }">
        <b-form-group
            label="Fecha inicial"
            class="mt-4">
          <b-form-input
              type="date"
              v-model="event.initialDate">
          </b-form-input>
        </b-form-group>
        <span class="text-danger">{{ errors[0] }}</span>
      </ValidationProvider>


      <ValidationProvider name="fecha final" rules="required" v-slot="{ errors }">
        <b-form-group
            label="Fecha inicial"
            class="mt-4">
          <b-form-input
              type="date"
              v-model="event.endDate">
          </b-form-input>
        </b-form-group>
        <span class="text-danger">{{ errors[0] }}</span>
      </ValidationProvider>


      <b-row class="row mt-4">
        <b-col class="col">
          <div class="form-group" v-for="(postHour, key) in event.hourly" :key="key">
            <label for="value">Dia</label>
            <b-form-select class="form-select"
                           v-model="event.hourly[key].day"
                           :options="optionsWeek">
            </b-form-select>
          </div>
        </b-col>
        <div class="col">
          <div class="form-group" v-for="(postHour, key) in event.hourly" :key="key">
            <label for="value">Hora</label>
            <input type="time" v-model="event.hourly[key].hourly" required="required" name="label"
                   class="form-control"/>
          </div>
        </div>
        <b-col class="col mt-4">
          <button class="btn btn-success btn-sm" v-if="event.hourly.length < 7" @click.prevent="moreDays">+</button>
          <button class="btn btn-danger btn-sm" @click.prevent="lessDays">-</button>
        </b-col>
      </b-row>


      <ValidationProvider name="ciudad" rules="required" v-slot="{ errors }">
        <b-form-group
            label="Ciudad"
            class="mt-4">
          <b-form-input
              type="text"
              v-model="event.city">
          </b-form-input>
        </b-form-group>
        <span class="text-danger">{{ errors[0] }}</span>
      </ValidationProvider>

      <b-form-group
          label="Lugar"
          class="mt-4">
        <b-form-input
            type="text"
            v-model="event.location">
        </b-form-input>
      </b-form-group>

      <ValidationProvider name="dirección" rules="required" v-slot="{ errors }">
        <b-form-group
            label="Dirección"
            class="mt-4">
          <b-form-input
              type="text"
              v-model="event.address">
          </b-form-input>
        </b-form-group>
      </ValidationProvider>

      <ValidationProvider name="presupuesto diario" rules="required" v-slot="{ errors }">
        <b-form-group
            label="Presupues diario"
            class="mt-4">
          <b-form-input
              type="number"
              v-model="event.dailyBudget">
          </b-form-input>
        </b-form-group>
        <span class="text-danger">{{ errors[0] }}</span>
      </ValidationProvider>


      <ValidationProvider name="presupuesto total" rules="required" v-slot="{ errors }">
        <b-form-group
            label="Presupuesto total"
            class="mt-4">
          <b-form-input
              type="number"
              v-model="event.totalBudget">
          </b-form-input>
        </b-form-group>
        <span class="text-danger">{{ errors[0] }}</span>
      </ValidationProvider>


      <div class="text-end mt-4">
        <b-button :disabled="!event.banner" type="submit" variant="primary">Guardar</b-button>
      </div>


    </b-form>
  </ValidationObserver>
</template>

<script>
export default {
  name: "formEvents",
  data() {
    return {
      event: {
        idItalentt: null,
        name: null,
        banner: null,
        typePersonal: null,
        initialDate: null,
        endDate: null,
        hourly: [{
          day: "",
          hourly: ""
        }],
        city: null,
        location: null,
        address: null,
        dailyBudget: null,
        totalBudget: null,
        status: 'open',
      },
      options: [
        {value: 'hombre', text: 'Hombre'},
        {value: 'mujer', text: 'Mujer'},
        {value: 'mixto', text: 'Mixto'},
      ],
      optionsWeek: [
        {value: 'lunes', text: 'lunes'},
        {value: 'martes', text: 'martes'},
        {value: 'miercoles', text: 'miercoles'},
        {value: 'jueves', text: 'jueves'},
        {value: 'viernes', text: 'viernes'},
        {value: 'sabado', text: 'sabado'},
        {value: 'domingo', text: 'domingo'},
      ]
    }
  },
  methods: {
    submit() {
      const formData = this.buildFormData();
      this.$emit('save', formData)
    },
    buildFormData() {
      const formData = new FormData();
      for (let prop in this.event) {

        if (prop == 'hourly') {
          formData.append('hourly', JSON.stringify(this.event[prop]));
        } else {
          formData.append(prop, this.event[prop]);
        }

      }
      return formData
    },
    moreDays() {
      this.event.hourly.push({
        day: "",
        hourly: ""
      })
    },
    lessDays() {
      this.event.hourly = this.event.hourly.slice(0, -1);
    },
    bannerUpload(file) {
      this.event.banner = file[0];
    }
  }
}
</script>

<style scoped>

</style>
