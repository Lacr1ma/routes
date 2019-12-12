function demo() {
  // Create resource entity
  storeResource('/api/demo/photos', {title: 'Created by js.'}).then(function (isOk) {
    console.log(isOk);
  });

  // Retrieve requested entity data
  readResource('/api/demo/photos/1').then(function (entity) {
    console.log(entity);
  });

  // Update resource entity
  updateResource('/api/demo/photos/1', {title: 'Title 1'}).then(function (isOk) {
    console.log(isOk);
  });

  // Delete resource entity
  deleteResource('/api/demo/photos/999').then(function (isOk) {
    console.log(isOk);
  });

  // Retrieve all recourse entities
  listResource('/api/demo/photos').then(function (entities) {
    console.log(entities);
  });
}
