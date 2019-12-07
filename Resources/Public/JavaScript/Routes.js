/**
 * Fetch the specific recourse
 *
 * @param {string}   url         Endpoint route to call
 * @return {Array}
 */
const readResource = async (url) => {
  initializeRequestHeaders();

  const result = await axios.get(url);

  return result.data[0];
};

/**
 * Retrieve all the resources related to endpoint
 *
 * @param {string}   url         Endpoint route to call
 * @return {Object}
 */
const listResource = async (url) => {
  initializeRequestHeaders();

  const result = await axios.get(url);

  return result.data;
};

/**
 * Delete the existing resource
 *
 * @param {string}   url         Endpoint route to call
 * @return {boolean}
 */
const deleteResource = async (url) => {
  initializeRequestHeaders();

  const result = await axios.delete(url);

  return result.data.success;
};

/**
 * Creates new resource and populates it with passed data
 *
 * @param {string}   url         Endpoint route to call
 * @param {Object}   data        Contains properties that should be updated on an object
 * @return {boolean}
 */
const createResource = async (url, data) => {
  initializeRequestHeaders();

  const result = await axios.post(url, {data: data});

  return result.data.success;
};

/**
 * Populates the requested resource with passed data.
 *
 * @param {string}   url         Endpoint route to call
 * @param {Object}   data        Contains properties that should be updated on an object
 * @return {boolean}
 */
const updateResource = async (url, data) => {
  initializeRequestHeaders();

  const result = await axios.put(url, {data: data});

  return result.data.success;
};

/**
 * Sets the proper headers for all the requests using axios.
 * We want all requests that made by axios were related to json data
 * and csrf token initialized if it is available.
 */
const initializeRequestHeaders = () => {
  const csrf = document.head.querySelector('meta[name="x-csrf-token"]');

  axios.defaults.headers.common['Accept'] = 'application/json';
  axios.defaults.headers.common['Content-Type'] = 'application/json';
  axios.defaults.headers.common['X-CSRF-TOKEN'] = csrf ? csrf.content : '';
};
