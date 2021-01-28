import Route from '@ember/routing/route';

export default class TestCompoRoute extends Route {
  model() {
    return [
      { nom: 'Charly', desc: 'Je suis grand' },
      { nom: 'Arthur', desc: 'Je suis petit...' },
    ];
  }
}
