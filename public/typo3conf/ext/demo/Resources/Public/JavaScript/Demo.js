function demo() {
  // Create resource entity
  createResource('/api/demo/entity', {title: 'Created by js.'}).then(function (isOk) {
    console.log(isOk);
  });

  // Retrieve requested entity data
  readResource('/api/demo/entity/1').then(function (entity) {
    console.log(entity);
  });

  // Update resource entity
  updateResource('/api/demo/entity/1', {title: 'Title 1'}).then(function (isOk) {
    console.log(isOk);
  });

  // Delete resource entity
  deleteResource('/api/demo/entity/999').then(function (isOk) {
    console.log(isOk);
  });

  // Retrieve all recourse entities
  listResource('/api/demo/entity').then(function (entities) {
    console.log(entities);
  });
}
