<template>
    <div class="">
        <div class="modal show fade" id="exampleModal" tabindex="-1" style="display: block;" v-if="isOpen">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Novo Endereço</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="closeModalCreated"></button>
                    </div>
                    <div class="modal-body">
                        <form  @submit.prevent="submitForm">
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">CEP:</label>
                                <input type="text" class="form-control" id="cep" v-model="formData.cep">
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Logradouro:</label>
                                <input type="text" class="form-control" id="logradouro" v-model="formData.logradouro">
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Bairro:</label>
                                <input type="text" class="form-control" id="bairro" v-model="formData.bairro">
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Cidade:</label>
                                <input type="text" class="form-control" id="cidade" v-model="formData.cidade">
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Estado:</label>
                                <input type="text" class="form-control" id="uf" v-model="formData.uf">
                            </div>


                        <!-- </div> -->
                            <div class="modal-footer">
                                <button  type="button" class="btn btn-secondary" @click="closeModalCreated">Fechar</button>
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show" v-if="isOpen"></div>
   </div>
</template>

<script>
import { ref, defineEmits } from 'vue';
import axios from 'axios';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
    export default {
        props: {
            isOpen: Boolean
        },
        setup(props, { emit }) {

            const formData = ref({
                cep: '',
                logradouro: '',
                bairro: '',
                cidade: '',
                uf: ''
            });


            const closeModalCreated = () => {
                emit('closeModalCreated');
            };

           const submitForm = () =>{
                axios.post('http://testes.my/api/enderecos', formData.value)
                        .then((response) => {

                            console.log(response);

                                    if(response.data.status =='success'){
                                        toast.success("Cadastro Realizado!", {
                                                autoClose: 3000,
                                            })
                                            closeModalCreated();
                                    }

                                    toast.success("Error", {
                                            autoClose: 3000,
                                        })

                            })
                        .catch((error)=>{
                                console.log(error)
                                    if(error.response.status === 422){
                                        toast.error(error.response.data.message,{
                                        autoClose: 3000,
                                        })
                                    }else if(error.data.status =='error'){

                                        toast.error('erro ao tenta cadastrar!',{
                                            autoClose: 3000,
                                            })
                                    }

                            })
                        .finally(() => this.loading = false)


            };

            return {
                formData,
                closeModalCreated,
                submitForm
            };
        },

    }
</script>
