import { Tag } from '@/types/Todo/Tag'
import { Status } from './Status'

export interface Todo {
  id: number;
  title: string;
  description?: string;
  status: Array<Status>;
  tags?: Array<Tag>;
  dateCreated?: string;
  dateUpdated?: string;
}
