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
					<th>Task</th>
					<th>Status</th>
					<th>#</th>
					<th>#</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="(task, index) in tasks" :key="index">
					<td>{{ task.name }}</td>
					<td>{{ task.status }}</td>
					<td>
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
			tasks: [
				{
					name: "Finish this todo-app",
					status: "In-progress",
				},
				{
					name: "Eat some food",
					status: "To-do",
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
	width: 100%;
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
	max-width: 600px;
	width: 60vw;
	min-width: 300px;
	margin: 5vh auto;
	border-collapse: collapse;
}

.task-table th, .task-table td {
	text-align: left;
	padding: 0.5vh 2vw;
	background-color: #ffc107;
	color: #000;
}

.task-table td {
	background-color: white;
	border-bottom: 1px solid #000;
}
</style>
