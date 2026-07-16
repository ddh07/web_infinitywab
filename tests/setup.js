import { config } from '@vue/test-utils'
import { vi } from 'vitest'

// Mock Laravel Mix/Vite assets
config.global.mocks = {
  asset: vi.fn((path) => `/${path}`),
  route: vi.fn((name, params = {}) => `/${name.replace(/\./g, '/')}${Object.keys(params).length ? '?' + new URLSearchParams(params).toString() : ''}`),
  auth: vi.fn(() => ({
    user: null,
    check: vi.fn(() => false),
    guest: vi.fn(() => true)
  })),
  csrf_token: vi.fn(() => 'test-csrf-token'),
  trans: vi.fn((key, replace = {}) => {
    let translation = key
    Object.keys(replace).forEach(search => {
      translation = translation.replace(`:${search}`, replace[search])
    })
    return translation
  })
}

// Mock window.axios
global.axios = {
  get: vi.fn(),
  post: vi.fn(),
  put: vi.fn(),
  delete: vi.fn(),
  patch: vi.fn(),
  interceptors: {
    request: {
      use: vi.fn()
    },
    response: {
      use: vi.fn()
    }
  }
}

// Mock window.Laravel
global.Laravel = {
  csrfToken: 'test-csrf-token'
}

// Mock localStorage
const localStorageMock = {
  getItem: vi.fn(),
  setItem: vi.fn(),
  removeItem: vi.fn(),
  clear: vi.fn()
}
global.localStorage = localStorageMock

// Mock sessionStorage
const sessionStorageMock = {
  getItem: vi.fn(),
  setItem: vi.fn(),
  removeItem: vi.fn(),
  clear: vi.fn()
}
global.sessionStorage = sessionStorageMock

// Mock window.location
Object.defineProperty(window, 'location', {
  value: {
    href: 'http://localhost',
    origin: 'http://localhost',
    pathname: '/',
    search: '',
    hash: '',
    assign: vi.fn(),
    replace: vi.fn(),
    reload: vi.fn()
  },
  writable: true
})

// Mock console methods for cleaner test output
global.console = {
  ...console,
  log: vi.fn(),
  debug: vi.fn(),
  info: vi.fn(),
  warn: vi.fn(),
  error: vi.fn()
}
