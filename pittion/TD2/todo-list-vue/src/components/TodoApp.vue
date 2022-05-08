<template>
	<div class="container">
		<h2>{{ title }}</h2>

		<div class="flex">
			<input @keyup.enter="submitTask" v-model="newTask" type="text" placeholder="Enter task" class="form-input" />
			<button @click="submitTask" class="btn-submit">SUBMIT</button>
		</div>

		<table class="task-table">
			<thead>
				<tr>
					<th class="text-td" >Task</th>
					<th class="text-td">Status</th>
					<th class="icon-td">#</th>
					<th class="icon-td">#</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="(task, index) in tasks" :key="index">
					<td class="text-td"><span :class="{'finished': task.status === lastStatus() }">{{ task.name }}</span></td>
					<td :class="{'text-danger': task.status === 'to-do','text-warning': task.status === 'in-progress' , 'text-sucess': task.status === 'done'}" >
						<span @click="changeStatus(index)" class="cursor">{{ firstCharUpper(task.status) }}</span></td>
					<td class="icon-td">
						<div @click="editTask(index)"><span class="fa fa-pen"></span></div>
					</td>
					<td><div @click="deleteTask(index)"><span class="fa fa-trash"></span></div></td>
				</tr>
			</tbody>
		</table>
	</div>
</template>

<script>
export default {
	title: "",
	props: {
		title: String,
	},
	data() {
		return {
			newTask: "",
			editedTask: null,
			availableStatues: ["to-do", "in-progress", "done"],
			tasks: [
				{
					name: "Finish this todo-app",
					status: "in-progress",
				},
				{
					name: "Eat some food",
					status: "to-do",
				}
			],
		}
	},
	methods: {
		submitTask() {
			if(this.newTask.length > 0) {
				if(this.editedTask !== null) {
					this.tasks[this.editedTask].name = this.newTask;
					this.editedTask = null;
				} else {
					this.tasks.push({
						name: this.newTask,
						status: "To-do",
					});
				}
				this.newTask = "";
			}
		},
		deleteTask(index) {
			this.tasks.splice(index, 1);
		},
		editTask(index) {
			this.newTask = this.tasks[index].name;
			this.editedTask = index;
		},
		changeStatus(index) {
			this.tasks[index].status = this.availableStatues[(this.availableStatues.indexOf(this.tasks[index].status) + 1) % this.availableStatues.length];
		},
		firstCharUpper(str) {
			return str.charAt(0).toUpperCase() + str.slice(1);
		},
		lastStatus() {
			return this.availableStatues[this.availableStatues.length - 1];
		}
	}
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
template {
	box-sizing: border-box;
	width: 100%;
	height: 100%;
}

.container {
	margin: 0 auto;
	width: 80vw;
	min-width: 400px;
}

.container h2 {
	text-align: center;
}

.flex {
	width: 60vw;
	min-width: 300px;
	margin: 0 auto;
	display: flex;
	flex-direction: row;
	align-items: center;
	justify-content: center;
}

.flex input[type="text"] {
	height: 1vh;
	padding: 0.5vh 2vw 0.5vh 2vw;
}

.btn-submit {
	height: 2.5vh;
	padding: 0.25vh 2vw;
	color: #000;
	background-color: #ffc107;
	border-color: #ffc107;
	border-radius: 0;
}

.task-table {
	max-width: 800px;
	width: 60vw;
	min-width: 400px;
	margin: 5vh auto;
	border-collapse: collapse;
}

.task-table th, .task-table td {
	text-align: left;
	padding: 0.5vh 2vw;
	background-color: #ffc107;
}

.task-table td {
	background-color: white;
	border-bottom: 1px solid #000;
}

.cursor{
	cursor: pointer;
}

.text-td {
	min-width: 15vw;
	width: auto;
}

.icon-td {
	width: 5vw;
}

.finished {
	text-decoration: line-through;
}

.text-danger {
	color: #dc3545;
}

.text-warning {
	color: #ffc107;
}

.text-sucess {
	color: #28a745;
}

</style>
