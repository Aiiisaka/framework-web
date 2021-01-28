import EmberRouter from '@ember/routing/router';
import config from 'first-project/config/environment';

export default class Router extends EmberRouter {
  location = config.locationType;
  rootURL = config.rootURL;
}

Router.map(function () {
  this.route('user');
  this.route('client', function() {
    this.route('detail');
  });
  this.route('test-compo');
});
