<template>
    <div class="container">
        <div class="row justify-content-center pt-5 pb-4">
            <h2 class="fw-bold">Данные РосРеестра</h2>
        </div>

        <div class="row justify-content-center">
            <form @submit.prevent="submit" class="pb-5 pt-0">

                <div class="form-floating mb-3">
                    <textarea
                        v-model="fields.plots"
                        :class="{'is-invalid': errors && errors.plots}"
                        :aria-describedby="errors && errors.plots
                            ? 'plots-validation-feedback'
                            : false"
                        type="text"
                        id="plots"
                        name="plots"
                        placeholder="Кадастровые номера"
                        class="form-control rounded-4"
                        style="height: 120px"
                    ></textarea>
                    <label for="plots">Кадастровые номера</label>
                    <div
                        v-if="errors && errors.plots"
                        id="plots-validation-feedback"
                        class="invalid-feedback"
                    >
                        <span v-for="(error, index) in errors.plots" :key="index">
                            {{ error }}
                        </span>
                    </div>
                </div>

                <button
                    type="submit"
                    class="mb-2 btn btn-lg rounded-4 btn-primary"
                >
                    Получить данные
                </button>
            </form>
        </div>

        <div v-if="plots.length" class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Номер</th>
                        <th scope="col">Адрес</th>
                        <th scope="col">Цена</th>
                        <th scope="col">Площадь</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="plot in plots" :key="plot.number">
                        <th scope="row">{{ plot.number }}</th>
                        <td>{{ plot.address }}</td>
                        <td>{{ plot.price }}</td>
                        <td>{{ plot.area }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
            <div id="toast-error" class="toast" data-bs-delay="2000" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <i class="bi bi-check-square-fill text-danger me-2 fs-5"></i>
                    <strong class="me-auto">Ошибка!</strong>
                    <small>Только что</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Что-то пошло не так.
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                fields: {plots: '69:27:0000022:1306,69:27:0000022:1307'},
                plots: [],
                errors: {}
            }
        },
        methods: {
            submit() {
                this.errors = {};
                this.plots = [];
                axios.get(`/plots`, {params: this.fields}).then(response => {
                    this.plots = response.data;
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                    } else {
                        const toastEl = document.getElementById('toast-error');
                        const toast = new bootstrap.Toast(toastEl);
                        toast.show();
                    }
                });
            }
        }
    }
</script>
