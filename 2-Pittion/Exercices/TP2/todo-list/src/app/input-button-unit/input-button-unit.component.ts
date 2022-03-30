import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-input-button-unit',
  template: `
    <p>input-button-unit works! The title is: {{ title }}</p>

    <input [value]="title" (keyup.enter)="changeTitle($event.target.value)" />
    <button (click)="changeTitle('Button Clicked!')">Save</button>
  `,
  styleUrls: ['./input-button-unit.component.scss'],
})
export class InputButtonUnitComponent implements OnInit {
  title = 'Hello World';

  constructor() {}

  changeTitle(newTitle: string): void {
    this.title = newTitle;
  }

  ngOnInit(): void {}
}
