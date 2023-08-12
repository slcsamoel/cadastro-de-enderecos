<template>
    <div class="">
        <div class="modal show fade" id="exampleModal" tabindex="-1" style="display: block;" v-if="isOpen">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-titl fs-5" id="exampleModalLabel">Tem Certeza que deseja excluir esse endereço?</h1>
                        <button type="button" class="btn-close" @click="closeModalDelete"></button>
                    </div>
                        <div class="modal-footer">
                            <button  type="button" class="btn btn-secondary" @click="closeModalDelete">Fechar</button>
                            <button type="button" class="btn btn-primary" @click="submitForm">Deletar</button>
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
                axios.delete(`http://127.0.0.1:8000/api/enderecos/${props.data.id}`)
                        .then((response) => {
                            console.log(response);
                                    if(response.data.status =='success'){
                                        toast.success("Excluido com sucesso!", {
                                                autoClose: 3000,
                                            })
                                            closeModalDelete();
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

            const closeModalDelete = () => {
                emit('closeModalDelete');
            };

            return {
                closeModalDelete,
                submitForm
            };
        },

}
</script>
