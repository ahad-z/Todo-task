<template>
<div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="mt-5 col-md-8">
            <div class="card" style="width: 600px;">
                <div class="card-body">
                    <input type="text" class="form-control" v-model="form.task" placeholder="Enter Your Target.........">
                    <div style="margin-top: 10px;">
                        <button style="float: right;" class="btn btn-primary"  @click="saveTaskData()">Add Your Task</button>
                    </div>
                    <div style="margin-top: 10px;">
                        <a href="#comtask" @click="completeTask()" data-toggle="modal" class="card-link btn btn-success">Complete Task</a>
                    </div>
                    <br>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item" v-for="task in tasks">
                            <input @click="updateDoneTask(task.id)"  type="checkbox" class="checkbox" v-model="task.status">
                            <span :class="{iteamDone : task.status==1}" style="margin-left: 10px;">{{ task.task }}</span>
                            <div style="float: right;" class="btn-group">
                                <a class="btn btn-primary btn-sm" href="#EditTask" @click="getByID(task.id)" data-toggle="modal"><i class="fa fa-edit"></i></a>
                                <button class="btn btn-danger btm-sm" onclick="return confirm('Are you sure you want to delete this Task?')" @click="removeTask(task.id)"><i class="fa fa-trash"></i></button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
    <!-- Modal for Comeplete Task Show -->
     <div class="modal fade" id="comtask">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Complete task</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Sl</th>
                                <th scope="col">Task Name</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for=" (task, index) in DoneTask">
                                <th scope="row">{{ index+1 }}</th>
                                <td>{{ task.task }}</td>
                                <td class="badge badge-success"><span>{{ task.status == 1? 'Done!' : '' }}</span></td>
                            </tr>
                             <!-- <td colspan="3" class="text-center" >
                                <h5 style="color: red">No task complete Yet!</h5>
                            </td> -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- End modal -->
    <!-- Modal for Edit -->
     <div  class="modal fade" id="EditTask">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update task</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-group">
                        <div class="form-group">
                            <label for="name">Task</label>
                            <input type="text" class="form-control" v-model="singleTask.task">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" @click.prevent="UpdateTask()">Update</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End modal -->
</div>
</template>

<script>
export default {
    name: "todo",
    data(){
    	return{
    		form:{
                task:''
            },
            tasks:[],
            singleTask:{},
            DoneTask:[],

    	}
    },

    methods:{

        getTask() {
            axios.get(`http://127.0.0.1:8000/api/todo`).then(response => {
                this.tasks = response.data.tasks
            }).catch(error => {
                console.log(error)
            })  
        },

         saveTaskData() {
            let formData = this.form
            if(this.form.task == ''){
                toastr.warning('Please Enter a Task!')
            }else{
                axios.post(`http://127.0.0.1:8000/api/add/todo`,  formData).then(response => {
                    if(response.data.status){
                        toastr.success(response.data.message)
                        this.form =  {}
                        this.getTask()
                    }
                    

                }).catch(error => {
                    console.log(error)
                })
            }
        },

        updateDoneTask(id) {
           let Id = id
            axios.get(`http://127.0.0.1:8000/api/status/`+id,).then(response => {
                
                this.getTask();
            }).catch(error => {
                console.log(error)
            })


        },

        getByID(id){
            let taskId = id
            axios.get(`http://127.0.0.1:8000/api/show/`+taskId).then(response => {
               this.singleTask = response.data.task
            }).catch(error => {
                console.log(error)
            })

        },

        completeTask() {
            axios.get(`http://127.0.0.1:8000/api/complete-Task`).then(response => {
                this.DoneTask = response.data.completeTask
               
            }).catch(error => {
                console.log(error)
            })
        },

        UpdateTask(){
            let updateTask = this.singleTask
            axios.post(`http://127.0.0.1:8000/api/update-task`, updateTask ).then(response => {
                if(response.data.status){
                    toastr.success(response.data.message)
                }
                this.getTask()
                this.singleTask = {}

            }).catch(error => {
                console.log(error)
            })

        },

        removeTask(id){
            let taskId = id
            axios.get(`http://127.0.0.1:8000/api/delete/`+taskId).then(response => {
                if(response.data.status){
                    toastr.warning(response.data.message)
                }
                this.getTask()

            }).catch(error => {
                console.log(error)
            })
        },

    },
    mounted(){

        this.getTask()
    	
    }
}
</script>

<style scoped="">
    .list-group-item{
        padding: 0.75rem 0.25rem;
    }

    .iteamDone{
        text-decoration: line-through;
        color: #c5bbbb;
        font-size: 20px;
    }
</style>