<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teste Laravel</title>
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>
<body>

<div id="app">
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-5 text-center">{{ message }}</h1>

                <div class="row mb-5">
                    <div class="col-12 col-lg-4">
                        <div class="form-group mb-3">
                            <p>Faça uma busca por CEP, caso não seja encontrado nenhum na nossa base de dados, faremos uma busca externa:</p>
                            <input class="form-control" type="text" placeholder="CEP" maxlength="8" id="cep" v-model="cepSearch" :disabled="loading" />
                        </div>
                        <div class="form-group">
                            <p>Faça uma busca por Logradouro em nossa base de dados interna:</p>
                            <input class="form-control" type="text" placeholder="Logradouro" id="logradouro" v-model="logradouroSearch" />
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 offset-lg-2">
                        <p>Você também pode solicitar para que exiba todos os CEPs da nossa base de dados:</p>
                        <button class="btn btn-primary" v-on:click="searchAll">Exibir tudo!</button>
                    </div>
                </div>

                <hr>

                <table class="table table-bordered table-responsive mt-5">
                    <thead>
                    <tr>
                        <th>CEP</th>
                        <th>Logradouro</th>
                        <th>Bairro</th>
                        <th>Cidade</th>
                        <th>UF</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="address in adresses" :key="address.id">
                        <td>{{ address.cep }}</td>
                        <td>{{ address.logradouro }}</td>
                        <td>{{ address.bairro }}</td>
                        <td>{{ address.cidade }}</td>
                        <td>{{ address.uf }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script>
    var app = new Vue({
        el: '#app',
        data () {
            return {
                message: 'Teste Laravel/VueJS',
                cepSearch: null,
                logradouroSearch: null,
                loading: false,
                adresses: null
            }
        },
        mounted () {
            this.searchAll();
        },
        watch: {
            logradouroSearch (value) {
                this.searchLogradouro(value);
            },
            cepSearch (value) {
                if (value.length == 8) this.searchCep(value);
            }
        },
        methods: {
            searchAll () {
                axios
                    .get('api/cep')
                    .then(response => (this.adresses = response.data.adresses))
            },
            searchLogradouro (value) {
                this.loading = true;
                axios
                    .post('api/cep/find', {'logradouro': value})
                    .then((response) => {this.adresses = response.data.address})
                    .catch(e => console.log(e))
                    .finally(() => {
                        this.loading =  false
                    });
            },
            searchCep (value) {
                this.loading = true;
                axios
                    .post('api/cep/find', {'cep': value})
                    .then((response) => {this.adresses = response.data.address; console.log(response)})
                    .catch(e => console.log(e))
                    .finally(() => {
                        this.loading =  false
                    });
            }
        }
    })
</script>

</body>
</html>
