import { Tag } from '@/types/Todo/Tag'
import { Status } from './Status'

export interface Todo {
  id: number;
  title: string;
  description?: string;
  status: Status;
  tags?: Array<Tag>;
}
