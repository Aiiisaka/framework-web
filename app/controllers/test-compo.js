import Controller from '@ember/controller';
import { action } from '@ember/object';
import { tracked } from '@glimmer/tracking';
export default class TestCompoController extends Controller {
  @tracked visible;
  @action
  toggleVisible() {
    this.visible = !this.visible;
  }
}
