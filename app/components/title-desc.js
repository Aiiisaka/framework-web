import Component from '@glimmer/component';
import { action } from '@ember/object';
import { tracked } from '@glimmer/tracking';
export default class TitleDescComponent extends Component {
  @tracked visible;

  constructor() {
    super(...arguments);
    this.visible = this.args.visible;
  }

  @action
  toggleVisible() {
    this.visible = !this.visible;
  }
}
