<template>
  <ValidationObserver
    class="row justify-content-center"
    v-slot="{ handleSubmit }"
  >
    <form
      @submit.prevent="handleSubmit(save)"
      class="col-12 col-md-10 col-lg-8 col-xl-5 bg-light p-5 register-form"
    >
      <ValidationProvider name="nombre" rules="required" v-slot="{ errors }">
        <div class="form-group">
          <label class="login-text" for="names">Nombre completo</label>
          <input
            v-model="user.names"
            type="text"
            class="form-control"
            id="names"
            required
          />
          <span class="text-danger">{{ errors[0] }}</span>
        </div>
      </ValidationProvider>

      <div class="row">
        <div class="col-md-6">
          <ValidationProvider
            name="correo electronico"
            rules="required|email"
            v-slot="{ errors }"
          >
            <div class="form-group mt-2">
              <label class="login-text" for="email">Email</label>
              <input
                v-model="user.email"
                class="form-control"
                id="email"
                required
              />
              <span class="text-danger">{{ errors[0] }}</span>
            </div>
          </ValidationProvider>
        </div>
        <div class="col-md-6">
          <ValidationProvider
            name="contraseña"
            rules="required"
            v-slot="{ errors }"
          >
            <div class="form-group mt-2">
              <label class="login-text" for="password">Contraseña</label>
              <input
                v-model="user.password"
                type="password"
                class="form-control"
                id="password"
                required
              />
              <span class="text-danger">{{ errors[0] }}</span>
            </div>
          </ValidationProvider>
        </div>
      </div>

      <div class="form-group mt-2">
        <label class="login-text" for="dni">
          DNI
          <span class="h6 fw-normal">
            (Sube una imagen o un archivo en formato PDF)
          </span>
        </label>
        <div class="input-group mb-3">
          <input
            required
            @change="onFileDniChange"
            type="file"
            class="form-control"
            id="dni"
            accept="image/png, image/jpeg, .pdf"
          />
          <label class="input-group-text" for="dni">Cargar</label>
        </div>
      </div>

      <div class="form-group mt-2">
        <label class="login-text" for="doc_responsable">
          ID
          <span class="h6 fw-normal">
            (Sube una imagen o un archivo en formato PDF)
          </span>
        </label>
        <div class="input-group mb-3">
          <input
            required
            @change="onFileDocChange"
            type="file"
            class="form-control"
            id="doc_responsable"
            accept="image/png, image/jpeg, .pdf"
          />
          <label class="input-group-text" for="doc_responsable">Cargar</label>
        </div>
      </div>

      <div class="mt-3">
        <div class="form-check">
          <input
            name="isAdult"
            class="form-check-input"
            type="checkbox"
            v-model="user.is_adult"
          />
          <label class="form-check-label" for="isAdult">
            Soy mayor de 18 años
          </label>
        </div>
        <div class="form-check">
          <input
            name="policyPrivacy"
            class="form-check-input"
            type="checkbox"
            v-model="user.policy_privacy"
          />
          <label class="form-check-label" for="policyPrivacy">
            <a href="#">Política de privacidad</a>
          </label>
        </div>
      </div>

      <div class="d-grid gap-2 mt-3">
        <button type="submit" class="btn btn-create btn-block">
          Registrar
        </button>
      </div>
    </form>
  </ValidationObserver>
</template>

<script>
export default {
  name: 'Index',
  data() {
    return {
      user: {
        names: '',
        email: '',
        movil: '',
        dni: null,
        doc_responsable: null,
        is_adult: 0,
        policy_privacy: 0,
      },
    }
  },
  methods: {
    onFileDniChange(e) {
      let file = e.target.files[0]
      this.user.dni = file
    },
    onFileDocChange(e) {
      let file = e.target.files[0]
      this.user.doc_responsable = file
    },
    async save() {
      const formData = this.buildFormData()
      const response = await axios.post('/api/providerCreate', formData)
      toastr.success('Usuario registrado correctamente')
      this.$emit('saved')
    },
    buildFormData() {
      const formData = new FormData()
      for (let prop in this.user) {
        formData.append(prop, this.user[prop])
      }
      return formData
    },
  },
}
</script>

<style scoped>
.login-text {
  color: #2d3748;
  font-size: 20px;
  font-weight: 500;
}

.form-control {
  border: 1px solid #101a24;
  border-radius: 10px;
}

.register-form {
  min-width: 425px;
}
.btn-create {
  background: #101a24;
  border-color: #101a24;
  border-radius: 20px;
  color: #fff;
}
.btn-create:hover {
  border-color: #101a24;
  color: #101a24;
  background: #fff;
}
.sombra {
  box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);
}
</style>
