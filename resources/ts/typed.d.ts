declare global {
  interface TabSlot {
    create: { file?: string; icon?: string }
    edit: { file?: string; icon?: string }
    show: { file?: string; icon?: string }
    list: { file?: string; icon?: string }
    error: { file?: string; icon?: string }
  }

  type SlotType = 'create' | 'edit' | 'show' | 'list' | 'error'

  /**
   * Pagination type define
   */
  interface Page<T> {
    current_page: number
    data: T[]
    from: number
    last_page: number
    per_page: number
    to: number
    total: number
    next_page_url: string | null
    prev_page_url: string | null
    last_page_url: string | null
    first_page_url: string
  }

  /**
   * Authentication type define
   */
  interface AuthRequest {
    username: string
    password: string
    remember?: boolean
  }

  interface AuthError {
    message?: string
    errors?: {
      username?: string[]
      password?: string[]
    }
  }

  /**
   * Privilege type deine
   */
  type Permission = 'r' | 'rw'

  interface Privilege {
    group?: Permission
    user?: Permission
    document?: Permission
    search?: Permission
    authorities: string[]
  }

  interface PrivilegeRequest {
    group?: Permission
    user?: Permission
    document?: Permission
    search?: Permission
  }

  /**
   * Group type define
   */
  enum DocFields {
    'name',
    'identity',
    'department_id',
  }

  enum UserFields {
    'name',
    'identity',
    'department_id',
  }

  interface RuleCustom {
    documents: keyof typeof DocFields
    users: keyof typeof UserFields
  }

  interface Group {
    id: number
    name: string
    privileges: Privilege
    types: number[]
    departments: number[]
    searches: number[]
    custom: RuleCustom[]
    created_at: string
    updated_at: string
  }

  interface GroupRequest {
    name: string
    privileges: PrivilegeRequest
    types: number[]
    departments: number[]
    searches: number[]
    custom: RuleCustom[]
  }

  interface GroupError {
    message?: string
    errors?: {
      name?: string[]
      privileges?: string[]
      types?: string[]
      departments?: string[]
      searches?: string[]
      custom?: string[]
    }
  }
  /**
   * User type define
   */
  interface User {
    id: string
    name: string
    identity: string
    department_id: number
    phone: string
    email: string
    username: string
    groups: Group[]
    department: Department
    created_at: string
    updated_at: string
  }

  interface UserRequest {
    name: string
    identity: string
    department_id: number
    phone: string
    email: string
    username: string
    password: string
    password_confirmation: string
    groups: number[]
  }

  interface UserError {
    message?: string
    errors?: {
      name?: string[]
      identity?: string[]
      department_id?: string[]
      phone?: string[]
      email?: string[]
      username?: string[]
      password?: string[]
      groups?: sring[]
    }
  }

  interface DocType {
    id: number
    name: string
  }

  interface Department {
    id: number
    name: string
  }

  interface Search {
    id: number
    name: string
    fields: SearchField
  }

  interface SearchField {
    department: boolean
    doc_type: boolean
    name: boolean
    identity: boolean
    comment: boolean
    storage: boolean
  }

  interface SearchRequest {
    department_id: number
    doc_type_id: number
    entity: string
    identity: string
    name: string
    comment: string
    storage: string
    start_date: string
    end_date: string
  }

  interface Document {
    id: string
    doc_type_id: number
    department_id: number
    entity: string
    identity: string
    name: string
    comment: string
    storage?: string
    storage_old?: string
    storage_old: string
    doc_date: string
    created_at: string
    updated_at: string
    image: DocImage
    doc_type: DocType
    department: Department
  }

  interface DocImage {
    id: number
    filename: string
    driver: string
  }
}

export default {}
