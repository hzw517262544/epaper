package com.bootdo.epaper.dao;

import com.bootdo.epaper.domain.NewsDO;

import java.util.List;
import java.util.Map;

import org.apache.ibatis.annotations.Mapper;

/**
 * 
 * @author hzw
 * @email hao17681124518@163.com
 * @date 2018-12-13 19:26:44
 */
@Mapper
public interface NewsDao {

	NewsDO get(Integer id);
	
	List<NewsDO> list(Map<String, Object> map);
	
	int count(Map<String, Object> map);
	
	int save(NewsDO news);
	
	int update(NewsDO news);
	
	int remove(Integer ID);
	
	int batchRemove(Integer[] ids);
}
