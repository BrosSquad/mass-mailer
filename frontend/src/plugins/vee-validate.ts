import {
  alpha_num,
  between,
  confirmed,
  digits,
  dimensions,
  email,
  image,
  integer,
  is,
  length,
  max,
  max_value,
  min,
  min_value,
  numeric,
  oneOf,
  regex,
  required,
  required_if,
  size,
} from 'vee-validate/dist/rules';
import {extend} from 'vee-validate';

extend('email', email);
extend('alpha_num', alpha_num);
extend('numeric', numeric);
extend('integer', integer);
extend('image', image);
extend('length', length);
extend('max', max);
extend('min', min);
extend('min_value', min_value);
extend('max_value', max_value);
extend('confirmed', confirmed);
extend('regex', regex);
extend('required', required);
extend('required_if', required_if);
extend('size', size);
extend('between', between);
extend('dimensions', dimensions);
extend('oneOf', oneOf);
extend('is', is);
extend('digits', digits);
