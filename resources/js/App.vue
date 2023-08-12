<template>
        <div class="main">
            <div class="search">
				<form class="search-form"  @submit.prevent="searchSubmit">
					<input type="text" v-model="searchForm" max="8" required="required" placeholder="Buscar pelo CEP">
					<input type="submit" value="Buscar">
                    <input type="button" value="X" @click="limparBuscar" >
				</form>
			</div>

            <CriarComponent :isOpen="modalOpenCreated"  @closeModalCreated="closeModalCreated" ></CriarComponent>
            <button class="btn-novo" target="_blank" @click="openModalCreated" >&#128190</button>

        <ul class="cards">
            <li class="cards_item" v-for="(item, index) in enderecos" :key="index">
               <div class="card">
                <div class="card_content">
                <h2 class="card_title">Cep: {{item.cep}}</h2>
                <p class="card_text">Logradouro: {{item.logradouro}}</p>
                <p class="card_text">Bairro: {{item.bairro}}</p>
                <p class="card_text">Cidade: {{ item.cidade }} </p>
                <p class="card_text">Estado: {{item.uf }}</p>
                <button class="btn-cards card_btn" @click="openModalEdit(item)" >Editar</button>
                <button class="btn-cards card_btn" @click="openModalDelete(item)" >Deletar</button>
                </div>
            </div>
            </li>
        </ul>

        <EditarComponent :isOpen="modalOpenEdit"  :data="modalDataEdit" @closeModalEdit="closeModalEdit" ></EditarComponent>
        <DeleteComponent :isOpen="modalOpenDelete"  :data="modalDataDelete" @closeModalDelete="closeModalDelete"></DeleteComponent>

        </div>
</template>

<script>
import CriarComponent from './components/CriarComponent.vue';
import EditarComponent from './components/EditarComponent.vue';
import axios from 'axios';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import { ref  , defineEmits , onMounted} from 'vue';
import DeleteComponent from './components/DeleteComponent.vue';
    export default {
        components: { CriarComponent, EditarComponent, DeleteComponent },
        setup() {

            const searchForm = ref('')

            const modalOpenEdit = ref(false);
            const modalDataEdit = ref({});
            const modalOpenCreated = ref(false);
            const modalOpenDelete = ref(false);
            const modalDataDelete = ref({});
            const enderecos = ref([]);


            const openModalCreated = () =>{
                modalOpenCreated.value = true;
            }

            const closeModalCreated = () =>{
                modalOpenCreated.value = false;
                getEnderecos();
            }

            const openModalEdit = (item) => {
                    modalDataEdit.value = {
                        id : item.id,
                        cep: item.cep,
                        logradouro: item.logradouro,
                        bairro: item.bairro,
                        cidade: item.cidade,
                        uf: item.uf,
                    };
                    modalOpenEdit.value = true;
            };

            const closeModalEdit = () => {
                modalOpenEdit.value = false;
                modalDataEdit.value = {};
                getEnderecos();
            };

            const openModalDelete = (item) =>{
                modalDataDelete.value= {
                        id : item.id,
                        cep: item.cep,
                        logradouro: item.logradouro,
                        bairro: item.bairro,
                        cidade: item.cidade,
                        uf: item.uf,
                }
                modalOpenDelete.value =true ;
            }

            const closeModalDelete = (item) =>{
                modalOpenDelete.value =false;
                getEnderecos();
            }

            const searchSubmit = async () => {

                if(searchForm.value == ''){
                    return toast.error('Informe o CEP para a Buscar !',{
                                            autoClose: 3000,
                                        });
                }


                axios.post('http://127.0.0.1:8000/api/search', {cep : searchForm.value})
                        .then((response) => {

                            console.log(response);

                                    if(response.data.status){
                                        toast.error(response.data.message,{
                                            autoClose: 3000,
                                        })
                                    }else{
                                        enderecos.value = response.data;
                                    }


                        })
                        .catch((error)=>{
                                console.log(error)
                                if(error.response.status === 422){
                                    toast.error(error.response.data.message,{
                                    autoClose: 3000,
                                    })
                                }else if(error.data.status =='error'){

                                    toast.error('erro ao tenta Fazer a busca!',{
                                        autoClose: 3000,
                                    })
                                }

                        })

            }

            const limparBuscar = () => {
                    searchForm.value='';
                    getEnderecos();
            }


            const getEnderecos = async () => {
                axios.get('http://127.0.0.1:8000/api/enderecos')
                    .then((response) => {

                                if(response.data){
                                    enderecos.value = response.data;
                                }

                        })
                    .catch((error)=>{
                                toast.error('erro ao tenta buscar os endereços!',{
                                    autoClose: 1000,
                                    })
                    });

            };


            onMounted(() => {
                getEnderecos();
            });


            return {
                    searchForm,
                    enderecos,
                    modalOpenEdit,
                    modalDataEdit,
                    modalOpenCreated,
                    modalOpenDelete,
                    modalDataDelete,
                    openModalEdit,
                    closeModalEdit,
                    openModalCreated,
                    closeModalCreated,
                    openModalDelete,
                    closeModalDelete,
                    searchSubmit,
                    limparBuscar
            };


        },


    }
</script>
