import { Component, OnInit, Output, EventEmitter } from '@angular/core';

@Component({
  selector: 'app-input-button-unit',
  template: `
    <input
      class="todo-input"
      #inputElementRef
      [value]="title"
      (keyup.enter)="submitValue($event.target.value)"
    />

    <button class="btn" (click)="submitValue(inputElementRef.value)">
      Save
    </button>
  `,
  styleUrls: ['./input-button-unit.component.scss'],
})
export class InputButtonUnitComponent implements OnInit {
  title = 'Hello World';
  @Output() submit: EventEmitter<string> = new EventEmitter<string>();

  constructor() {}

  ngOnInit(): void {}

  submitValue(newTitle: string) {
    this.submit.emit(newTitle);
  }
}
