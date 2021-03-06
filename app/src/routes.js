export default [
  {
    path: '/',
    name: 'landing-page',
    component: require('components/Home')
  },
  {
    path: '/plus-student',
    name: 'plus-student',
    component: require('components/Forms/Student/PlusStudent')
  },
  {
    path: '/delete-student',
    name: 'delete-student',
    component: require('components/Forms/Student/DeleteStudent')
  },
  {
    path: '/exchange-student',
    name: 'exchange-student',
    component: require('components/Forms/Student/ExchangeStudent')
  },
  {
    path: '/plus-book',
    name: 'plus-book',
    component: require('components/Forms/Book/PlusBook')
  },
  {
    path: '/delete-book',
    name: 'delete-book',
    component: require('components/Forms/Book/DeleteBook')
  },
  {
    path: '/search-book',
    name: 'search-book',
    component: require('components/Forms/Book/SearchBook')
  },
  {
    path: '/plus-people',
    name: 'plus-people',
    component: require('components/Forms/People/PlusPeople')
  },
  {
    path: '/delete-people',
    name: 'delete-people',
    component: require('components/Forms/People/DeletePeople')
  },
  {
    path: '/exchange-people',
    name: 'exchange-people',
    component: require('components/Forms/People/ExchangePeople')
  },
  {
    path: '/plus-arq-morto',
    name: 'plus-arq-morto',
    component: require('components/Forms/ArqMorto/PlusArqMorto')
  },
  {
    path: '/delete-arq-morto',
    name: 'delete-arq-morto',
    component: require('components/Forms/ArqMorto/DeleteArqMorto')
  },
  {
    path: '/search-arq-morto',
    name: 'search-arq-morto',
    component: require('components/Forms/ArqMorto/SearchArqMorto')
  },
  {
    path: '/list-class',
    name: 'list-class',
    component: require('components/Forms/Lists/StudentsForClass')
  },
  {
    path: '/list-defaulters',
    name: 'list-defaulters',
    component: require('components/Forms/Lists/Defaulters')
  },
  {
    path: '/list-readers',
    name: 'list-readers',
    component: require('components/Forms/Lists/Readers')
  },
  {
    path: '/list-books',
    name: 'list-books',
    component: require('components/Forms/Lists/Books')
  },
  {
    path: '/about',
    name: 'about',
    component: require('components/About')
  },
  {
    path: '/backup',
    name: 'backup',
    component: require('components/Backup')
  },
  {
    path: '*',
    redirect: '/'
  }
]
