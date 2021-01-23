import { Tag } from '@/types/Todo/Tag'
import { Status } from './Status'

export interface Todo {
  uuid: string;
  title: string;
  description?: string;
  status: Array<Status>;
  tags?: Array<Tag>;
  createdAt?: Date;
  updatedAt?: Date;
}
