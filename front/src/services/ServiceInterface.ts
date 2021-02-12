import { AxiosResponse } from 'axios'

export interface ServiceInterface<T> {
  findAll(param: Record<string, string>): Promise<AxiosResponse>;
  find(uuid: string): Promise<AxiosResponse>;
  add(item: T): Promise<AxiosResponse>;
  update(item: T): Promise<AxiosResponse>;
  destroy(item: T): Promise<AxiosResponse>;
}
