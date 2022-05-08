const app = Vue.createApp({
  data() {
		return {
      title: 'My ToDo List',
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
						status: "to-do",
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
});

app.mount(".app");