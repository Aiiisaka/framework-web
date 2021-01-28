import Route from '@ember/routing/route';
import { action } from '@ember/object';
export default class ClientDetailRoute extends Route {
  @action
  fermer() {
    this.transitionTo('client');
  }
}
