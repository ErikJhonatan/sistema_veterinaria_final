const debounce = (fn, delay = 0, immediate = false) => {
    let timeout ;
    return (...args ) => {
      if (immediate && !timeout) fn(...args);
      clearTimeout(timeout);
  
      timeout = setTimeout(() => {
        fn(...args);
      }, delay);
    };
  };
  
  export default debounce;