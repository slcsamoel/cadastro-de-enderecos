<template>
    <div class="">
        <div class="modal show fade" id="exampleModal" tabindex="-1" style="display: block;" v-if="isOpen">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Endereço</h1>
                        <button type="button" class="btn-close" @click="closeModalEdit"></button>
                    </div>
                    <div class="modal-body">
                        <form  @submit.prevent="submitForm">
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">CEP:</label>
                                <input type="text" class="form-control" id="cep" maxlength="8" required="required" v-model="data.cep"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Logradouro:</label>
                                <input type="text" class="form-control" id="logradouro"  required="required" v-model="data.logradouro">
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Bairro:</label>
                                <input type="text" class="form-control" id="bairro"  required="required" v-model="data.bairro">
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Cidade:</label>
                                <input type="text" class="form-control" id="cidade"  required="required" v-model="data.cidade">
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Estado:</label>
                                <input type="text" class="form-control" id="uf"  maxlength="2" required="required" v-model="data.uf">
                            </div>

                        <!-- </div> -->
                            <div class="modal-footer">
                                <button  type="button" class="btn btn-secondary" @click="closeModalEdit">Fechar</button>
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
            isOpen: Boolean,
            data: Object,
        },

        setup(props, { emit }) {

            const submitForm = () =>{
                axios.patch(`http://127.0.0.1:8000/api/enderecos/${props.data.id}`, props.data)
                        .then((response) => {
                            console.log(response);
                                    if(response.data.status =='success'){
                                        toast.success("Atualizado com sucesso!", {
                                                autoClose: 3000,
                                            })
                                            closeModalEdit();
                                    }

                            })
                        .catch((error)=>{

                            if(error.response.status === 422){
                                    toast.error(error.response.data.message,{
                                     autoClose: 3000,
                                    })
                            }else if(error.data.status =='error'){

                                    toast.error('erro ao tenta Atualizar!',{
                                        autoClose: 3000,
                                        })
                            }

                        })
                        .finally(() => this.loading = false)
                 };

            const closeModalEdit = () => {
                emit('closeModalEdit');
            };

            return {
                closeModalEdit,
                submitForm
            };
        },

}
</script>
